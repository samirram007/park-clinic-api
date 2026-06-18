<?php

use App\Models\Doctor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Removes duplicate doctor records by name, keeping the one with the most complete data.
     * Priority: dual-type (both consultant & outdoor) > filled fields > most recent.
     */
    public function up(): void
    {
        // Find names that appear more than once
        $duplicates = Doctor::select('name', DB::raw('COUNT(*) as cnt'))
            ->groupBy('name')
            ->having('cnt', '>', 1)
            ->get();

        $removed = 0;

        foreach ($duplicates as $dup) {
            $records = Doctor::where('name', $dup->name)
                ->orderBy('id')
                ->get();

            // Score each record: higher = better to keep
            $scored = $records->map(function ($record) {
                $score = 0;

                // Prefer records with both consultant and outdoor types (dual-type)
                $types = $record->type ?? [];
                if (in_array('consultant', $types) && in_array('outdoor', $types)) {
                    $score += 100;
                } elseif (in_array('consultant', $types)) {
                    $score += 50;
                }

                // Prefer records with more filled content fields
                if (! empty($record->title))         $score += 5;
                if (! empty($record->education))     $score += 5;
                if (! empty($record->bio))           $score += 5;
                if (! empty($record->schedule))      $score += 5;
                if (! empty($record->department))    $score += 3;
                if (! empty($record->experience))    $score += 3;
                if (! empty($record->image))         $score += 2;
                if (! empty($record->rating))        $score += 2;
                if (! empty($record->is_active))     $score += 2;

                return ['id' => $record->id, 'score' => $score];
            });

            // Sort by score descending, then by id descending (keep newer on tie)
            $sorted = $scored->sort(function ($a, $b) {
                return $b['score'] - $a['score'] !== 0
                    ? $b['score'] - $a['score']
                    : $b['id'] - $a['id'];
            });

            // Keep the best one, delete the rest
            $keepId = $sorted->first()['id'];
            $toDelete = $sorted->skip(1)->pluck('id');

            Doctor::whereIn('id', $toDelete)->delete();
            $removed += $toDelete->count();
        }

        if ($removed > 0) {
            echo "Cleaned up {$removed} duplicate doctor records." . PHP_EOL;
        } else {
            echo 'No duplicate doctor records found.' . PHP_EOL;
        }
    }

    /**
     * Reverse the migration.
     *
     * We cannot restore deleted records, but re-running the seeder
     * (php artisan db:seed --class=DoctorSeeder) will recreate them
     * cleanly since the seeder now truncates before inserting.
     */
    public function down(): void
    {
        // No reversible action — data is reproducible via seeder
    }
};
