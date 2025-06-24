<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Collection as ModelsCollection;
use App\Models\Project;
use App\Traits\Common;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Collection extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:collection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collection Uploaded Successfully';

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

            $collection = DB::connection('mysql2')->select("SELECT crw_col_code, project, MAX(category) AS category FROM `new_live_product_details` WHERE project = 'SIL UTENSIL' AND crw_col_code != '' GROUP BY crw_col_code, project ORDER BY crw_col_code ASC;");

            $this->output->progressStart(count($collection));
            foreach ($collection as $item) {

                $projectId = Project::where('project_name', $item->project)->value('id');
                $categoryId = Category::where('category_name', $item->category)->value('id');

                ModelsCollection::Create([
                    'project_id' => $projectId,
                    'category_id' => $categoryId,
                    'collection_name' => $item->crw_col_code
                ]);
                $this->output->progressAdvance();
            }
            // Commit the transaction
            DB::commit();
            $this->info('Collections updated successfully');
        } catch (QueryException $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->info('Collections update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        } catch (Exception $e) {
            // Catch more generic exceptions
            DB::rollBack();
            $this->info('Collections update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        }
    }
}
