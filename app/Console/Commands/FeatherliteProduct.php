<?php

namespace App\Console\Commands;

use App\Models\Product;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FeatherliteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:featherlite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Featherlite products';

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

            $products = DB::connection('mysql2')->select("SELECT * FROM `featherlite` ORDER BY id ASC;");

            $this->output->progressStart(count($products));
            foreach ($products as $item) {
                $colorId = null;
                $styleId = null;
                $projectId = 8;
                $categoryId = null;
                $subCategoryId = null;
                $collectionId = null;
                $subCollectionId = null;
                $unitId = null;
                // $finishId = Finish::where('finish_name', $item->finish)->value('id');
                // dd($colorId, $styleId, $projectId, $categoryId, $subCategoryId, $collectionId, $subCollectionId, $unitId,$item->crw_col_code,$item->crw_sub_col_code);

                $products = Product::updateOrCreate([
                    'product_unique_id' => $item->product_sku,
                    'product_image' => $item->product_image,
                    'product_name' => $item->product_name,
                    'height' => null,
                    'width' => null,
                    'weight' => $item->product_weight,
                    'product_carat' => null,
                    'color_id' => $colorId,
                    'style_id' => $styleId,
                    'project_id' => $projectId,
                    'category_id' => $categoryId,
                    'sub_category_id' => $subCategoryId,
                    'collection_id' => $collectionId,
                    'sub_collection_id' => $subCollectionId,
                    'metal_type_id' => null,
                    'plating_id' => null,
                    'finish_id' => null,
                    'making_percent' => null,
                    'moq' => 1,
                    'crwcolcode' => null,
                    'crwsubcolcode' => null,
                    'gender' => null,
                    'cwqty' => 0,
                    'unit_id' => $unitId,
                    'net_weight' => $item->product_weight == "" ? null : $item->product_weight,
                    'keywordtags' => null,
                    'otherrate' => 0,
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
