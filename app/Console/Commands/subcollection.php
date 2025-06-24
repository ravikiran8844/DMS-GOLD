<?php

namespace App\Console\Commands;

use App\Models\Collection;
use App\Models\Project;
use App\Models\SubCollection as ModelsSubCollection;
use App\Traits\Common;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class subcollection extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:subcollection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subcollection uploaded successfully';

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

            $subcollection = DB::connection('mysql2')->select("SELECT crw_col_code, crw_sub_col_code, project FROM `new_live_product_details` WHERE project = 'SIL UTENSIL' AND crw_col_code != '' AND crw_sub_col_code != '' GROUP BY crw_col_code, crw_sub_col_code, project ORDER BY crw_col_code ASC, crw_sub_col_code ASC;");

            $this->output->progressStart(count($subcollection));
            foreach ($subcollection as $item) {

                $projectId = Project::where('project_name', $item->project)->value('id');
                $collectionId = Collection::where('collection_name', $item->crw_col_code)->value('id');

                ModelsSubCollection::Create([
                    'project_id' => $projectId,
                    'collection_id' => $collectionId,
                    'sub_collection_name' => $item->crw_sub_col_code
                ]);
                $this->output->progressAdvance();
            }
            // Commit the transaction
            DB::commit();
            $this->info('Subcollections updated successfully');
        } catch (QueryException $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->info('Subcollections update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        } catch (Exception $e) {
            // Catch more generic exceptions
            DB::rollBack();
            $this->info('Subcollections update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        }
    }
}
