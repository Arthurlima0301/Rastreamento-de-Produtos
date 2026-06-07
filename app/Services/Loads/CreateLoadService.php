<?php

namespace App\Services\Loads;

use App\Models\Load;
use App\Models\Roll;
use Illuminate\Support\Facades\DB;

class CreateLoadService
{
    /**
     * Create a load record and attach the selected rolls to it.
     */
    public function create(int $machineId, string $turn, array $rolls, $cuttedAt): void
    {
        DB::transaction(function () use ($machineId, $turn, $rolls, $cuttedAt) {
            $load = $this->createLoad($machineId, $turn, $cuttedAt);

            $this->attachRollsToLoad($rolls, $load->id);
        });
    }

    /**
     * Create a new load record in the database with the specified machine ID and turn.
     */
    public function createLoad(int $machineId, string $turn, $cuttedAt): Load
    {
        $load = Load::create([
            'cutted_at' => $cuttedAt ?? now(),
            'machine_id' => $machineId,
            'turn' => $turn,
            'observation' => null,
        ]);

        return $load;
    }

    /**
     * Attach the selected rolls to the load by creating entries in the pivot table.
     */
    public function attachRollsToLoad(array $rolls, int $loadId): void
    {
        foreach ($rolls as $roll) {
            $roll = Roll::findOrFail($roll['id']);

            $roll->load_id = $loadId;
            $roll->status = 'CORTADA';
            $roll->save();
        }
    }
}
