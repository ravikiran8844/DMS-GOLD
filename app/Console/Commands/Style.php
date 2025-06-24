<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Style as ModelsStyle;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Style extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:style';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Style Uploaded Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $style = DB::connection('mysql2')->select("SELECT * FROM `box`;");
            
            $this->output->progressStart(count($style));
            foreach ($style as $item) {
                $projectId = Project::where('project_name', $item->project_name)->value('id');

                ModelsStyle::Create([
                    'project_id' => $projectId,
                    'style_name' => $item->style
                ]);
                $this->output->progressAdvance();
            }
            // Commit the transaction
            DB::commit();
            $this->info('Style updated successfully');
        } catch (QueryException $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->info('Style update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        } catch (Exception $e) {
            // Catch more generic exceptions
            DB::rollBack();
            $this->info('Style update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        }
    }
}
