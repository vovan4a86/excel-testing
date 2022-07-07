<?php

	namespace App\Imports;

	use Carbon\Carbon;
	use Fanky\Admin\Models\Stock;
	use Fanky\Admin\Models\StockItem;
	use Maatwebsite\Excel\Concerns\Importable;
	use Maatwebsite\Excel\Concerns\ToModel;
	use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
	use Maatwebsite\Excel\Concerns\WithHeadingRow;

	class StockItemsImport implements ToModel, WithHeadingRow, WithCalculatedFormulas {

		use Importable;

		protected $stockId;

		public function __construct(int $stockId) {
			$this->stockId = $stockId;
		}

		/**
		 * @param array $row
		 *
		 * @return StockItem|null
		 */
		public function model(array $row) {
			if (isset($row['razmer']) && isset($row['st'])) {
				$title = $row['razmer'] . '-' . $row['st'];
				return new StockItem([
					'price_name' => $row['razmer'],
					'name' => $row['razmer'],
					'steel' => $row['st'],
					'weight' => $row['ves'],
					'gost' => $row['gost'],
					'title' => $title,
					'reserved' => $row['bron_tn'],
					'in_stock' => 1,
					'published' => 1,
					'stock_id' => $this->stockId,
					'updated_at' => Carbon::now()
				]);
			}
		}

		public function headingRow(): int {
			return 2;
		}

	}
