<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Project;
use App\Models\SubCategory as ModelsSubCategory;
use App\Traits\Common;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Subcategory extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:subcategory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'subcategory uploaded successfully';

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

            $subcategory = DB::connection('mysql2')->select("SELECT sub_category,category,project FROM `new_live_product_details` WHERE project = 'SIL UTENSIL' GROUP BY category, project,sub_category
            ORDER BY category ASC;");
            
            $this->output->progressStart(count($subcategory));
            foreach ($subcategory as $item) {
                $projectId = Project::where('project_name', $item->project)->value('id');
                $categoryId = Category::where('category_name', $item->category)->value('id');
                
                ModelsSubCategory::Create([
                    'project_id' => $projectId,
                    'category_id' => $categoryId,
                    'sub_category_name' => $item->sub_category
                ]);
                $this->output->progressAdvance();
            }
            // Commit the transaction
            DB::commit();
            $this->info('Subcategory updated successfully');
        } catch (QueryException $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->info('Subcategory update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        } catch (Exception $e) {
            // Catch more generic exceptions
            DB::rollBack();
            $this->info('Subcategory update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        }
    }
}
