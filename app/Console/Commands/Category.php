<?php

namespace App\Console\Commands;

use App\Models\Category as ModelsCategory;
use App\Models\Project;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Traits\Common;

class Category extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Category uploaded successfully';

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

            $category = DB::connection('mysql2')->select("SELECT category,project FROM `new_live_product_details` WHERE project = 'SIL UTENSIL' GROUP BY category, project
            ORDER BY category ASC;");

            $this->output->progressStart(count($category));
            foreach ($category as $item) {
                $projectId = Project::where('project_name', $item->project)->value('id');

                ModelsCategory::Create([
                    'project_id' => $projectId,
                    'category_name' => $item->category
                ]);
                $this->output->progressAdvance();
            }
            // Commit the transaction
            DB::commit();
            $this->info('Category updated successfully');
        } catch (QueryException $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->info('Category update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        } catch (Exception $e) {
            // Catch more generic exceptions
            DB::rollBack();
            $this->info('Category update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        }
    }
}
