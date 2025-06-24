<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Classification;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Finish;
use App\Models\MetalType;
use App\Models\Product;
use App\Models\Project;
use App\Models\Style;
use App\Models\SubCategory;
use App\Models\SubCollection;
use App\Models\Unit;
use App\Traits\Common;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Products extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

            $products = DB::connection('mysql2')->select("SELECT * FROM `new_live_product_details` WHERE project = 'SIL UTENSIL' ORDER BY id ASC;");

            $this->output->progressStart(count($products));
            foreach ($products as $item) {
                $colorId = property_exists($item, 'default_color') ? Color::where('color_name', 'like', '%' . $item->default_color  . '%')->value('id') : null;
                $styleId = property_exists($item, 'default_style') ? Style::where('style_name', 'like', '%' . $item->default_style . '%')->value('id') : null;
                $projectId = Project::where('project_name', $item->project)->value('id');
                $categoryId = Category::where('project_id',$projectId)->where('category_name', $item->category)->value('id');
                $subCategoryId = SubCategory::where('project_id',$projectId)->where('sub_category_name', $item->sub_category)->value('id');
                $collectionId = Collection::where('project_id',$projectId)->where('collection_name', $item->crw_col_code)->value('id');
                $subCollectionId = SubCollection::where('project_id',$projectId)->where('sub_collection_name', $item->crw_sub_col_code)->value('id');
                $unitId = Unit::where('unit_name', $item->unit_id)->value('id');
                // $finishId = Finish::where('finish_name', $item->finish)->value('id');
                // dd($colorId, $styleId, $projectId, $categoryId, $subCategoryId, $collectionId, $subCollectionId, $unitId,$item->crw_col_code,$item->crw_sub_col_code);

                $products = Product::updateOrCreate([
                    'product_unique_id' => $item->product_id,
                    'product_image' => $item->product_id . '.jpg',
                    'product_name' => $item->product_name,
                    'height' => $item->product_height == "" ? null : $item->product_height,
                    'width' => $item->product_width == "" ? null : $item->product_width,
                    'weight' => $item->product_weight,
                    'product_carat' => $item->default_carat,
                    'color_id' => $colorId,
                    'style_id' => $styleId,
                    'project_id' => $projectId,
                    'category_id' => $categoryId,
                    'sub_category_id' => $subCategoryId,
                    'collection_id' => $collectionId,
                    'sub_collection_id' => $subCollectionId,
                    'metal_type_id' => $item->metal_type,
                    'plating_id' => 1,
                    'finish_id' => 1,
                    'making_percent' => $item->making_percent,
                    'moq' => 1,
                    'crwcolcode' => $item->crw_col_code,
                    'crwsubcolcode' => $item->crw_sub_col_code,
                    'gender' => $item->gender,
                    'cwqty' => $item->cw_qty,
                    'unit_id' => $unitId,
                    'net_weight' => $item->net_weight == "" ? null : $item->net_weight,
                    'keywordtags' => $item->keyword_tag,
                    'otherrate' => $item->other_rate == "" ? 0.00 : $item->other_rate,
                    'created_by' => 1,
                ]);
                $this->output->progressAdvance();
            }
            // Commit the transaction
            DB::commit();
            $this->info('Products updated successfully');
        } catch (QueryException $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->info('Products update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        } catch (Exception $e) {
            // Catch more generic exceptions
            DB::rollBack();
            $this->info('Products update failed: ' . $e->getMessage());
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), 1, request()->ip(), gethostname());
        }
    }
}
