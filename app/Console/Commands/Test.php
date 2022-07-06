<?php namespace App\Console\Commands;

use App\Repositories\Interfaces\StockItemRepositoryInterface;
use Fanky\Admin\Models\Stock;
use Illuminate\Console\Command;
use Phpexcelreader\Phpexcelreader\Spreadsheet_Excel_Reader as Reader;

class Test extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
		$stock = Stock::find(6);
        $filepath = public_path('uploads/test_price.xls');
        $reader = new Reader();
        $reader->setOutputEncoding('UTF-8');
        $reader->read($filepath);

        $repository = app(StockItemRepositoryInterface::class)->parseXLS($reader, $stock);

        return 0;
    }

}
