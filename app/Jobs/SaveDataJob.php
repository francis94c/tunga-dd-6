<?php

namespace App\Jobs;

use App\Models\ChallengeItem;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use JsonMachine\JsonMachine;

class SaveDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileLocation)
    {
        // File location could be appended with date and time for more uniqueness.
        $jsonArray = JsonMachine::fromFile($fileLocation);

        $cacheKey = str_replace("..", "", str_replace("/", "-", $fileLocation));

        // Our Error Recovery Information Pointer
        // Cache driver is REDIS (predis/predis)
        $lastSaved = Cache::get($cacheKey);

        if ($lastSaved === null) {
            // First time, create a session id;
            $sessionId = date('YmdHis');
        } else {
            // Retrieve a session id.
            $sessionId = $lastSaved['session_id'];
        }

        foreach ($jsonArray as $index => $data) {
            if ($lastSaved !== null) {
                if ($lastSaved['index'] == $index) {
                    info("Resuming safely...");
                    // In case we saved but didn't record it.
                    // Let's make sure we are not repeating ourselves.
                    $challengeItem = ChallengeItem::where('session_id', $sessionId)->latest()->first();
                    $lastSaved = null;
                    if (
                        $challengeItem && $challengeItem->name == $data['name'] &&
                        $challengeItem->address == $data['address'] &&
                        $challengeItem->checked == $data['checked'] &&
                        $challengeItem->description == $data['description']
                    ) {
                        continue;
                    }
                    // Go ahead and process this data from the 'Filter Logic' section.
                } else {
                    continue;
                }
            }

            // Filter Logic
            $dob = $data['date_of_birth'] ? Carbon::parse(str_replace("/", "-", $data['date_of_birth'])) : null;

            // We can switch filter conditions here
            if ($dob && $dob->age >= 18 && $dob->age <= 65) {
                // Save Item.
                ChallengeItem::create([
                    'session_id'                  => $sessionId,
                    'name'                        => $data['name'],
                    'address'                     => $data['address'],
                    'checked'                     => $data['checked'],
                    'description'                 => $data['description'],
                    'date_of_birth'               => $dob->format('Y-m-d H:i:s') ?? null,
                    'interest'                    => $data['interest'],
                    'email'                       => $data['email'],
                    'account'                     => $data['account'],
                    'credit_card_type'            => $data['credit_card']['type'],
                    'credit_card_number'          => $data['credit_card']['number'],
                    'credit_card_name'            => $data['credit_card']['name'],
                    'credit_card_expiration_date' => $data['credit_card']['expirationDate'] ? Carbon::parse($data['credit_card']['expirationDate'])->format('Y-m-d H:i:s') : null
                ]);
            }

            // Record that we've save the item by recording it's index.
            Cache::put($cacheKey, [
                'index'      => $index,
                'session_id' => $sessionId
            ]);

            info("Processed Data: $index");
        }

        info ("Done");

        // We re done here. Remove error recovery data.
        Cache::forget($cacheKey);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
