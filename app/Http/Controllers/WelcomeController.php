<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ResponseStruct;
use Illuminate\Support\Str;
use App\Models\ItemModel;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Sector;
use App\Models\Voltage;

class WelcomeController extends Controller
{
    private ResponseStruct $responseStruct;

    public function __construct()
    {
        $this->responseStruct = new ResponseStruct();
    }

    public function index(Request $request)
    {
        $this->responseStruct = $this->loadFile($request);

        if (count($this->responseStruct->getResult())) {
            $this->save();
        }

        if (count($this->responseStruct->getMessages())) {
            $this->responseStruct->setTypeMessage('warning');
        }

        return view('welcome', ['responseStruct' => $this->responseStruct->returnStruct()]);
    }


    private function save()
    {
        $list = $this->responseStruct->getResult();
        $messages = [];

        foreach ($list as $key => $item)
        {
            $register = true;
            if (!property_exists($item, 'OID')) {
                $messages[] = 'Register ' . $key+1 . ' not added, OID missing';
            }
            else
            {
                $product = new Product();
                $existProduct = $product->where('oid', $item->OID)->first();
                if ($existProduct) {
                    $messages[] = 'Register already existis to OID ' . $item->OID;
                    $register = false;
                } else {
                    $product->oid = $item->OID;
                }

                if (property_exists($item, 'SectorName')) {
                    $product->id_sector = $this->getId(new Sector(), $item->SectorName);
                }

                if (property_exists($item, 'Latitude')) {
                    $product->latitude = $item->Latitude;
                }

                if (property_exists($item, 'Longitude')) {
                    $product->longitude = $item->Longitude;
                }

                if (property_exists($item, 'Manufacturer')) {
                    $product->id_manufacturer = $this->getId(new Manufacturer(), $item->SectorName);
                }

                if (property_exists($item, 'Model')) {
                    $product->id_item_model = $this->getId(new ItemModel(), $item->Model);
                }

                if (property_exists($item, 'Voltage')) {
                    $product->id_voltage = $this->getId(new Voltage(), $item->Voltage);
                }

                $this->responseStruct->setMessages($messages);

                if ($register) {
                    $product->save();
                }
            }
        }
    }

    private function getId($entity, $value) : int
    {
        $fetch = $entity->where('name', $value)->first();
        if (!$fetch) {
            $fetch = $entity;
            $fetch->name = $value;
            $fetch->save();
        }

        return $fetch->id;
    }

    private function loadFile(Request $request) : ResponseStruct
    {
        $returnStruct = new ResponseStruct();
        $originalName = $request->file('document_file')->getClientOriginalName();
        $extension = substr($originalName, strrpos($originalName, '.') + 1);
        $fullPath = $request->file('document_file')->getRealPath();
        $reader = null;
        $list = [];

        switch ($extension) {
            case 'xls':
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                break;
            case 'xlsx':
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                break;
            case 'csv':
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                break;
            default:
                /** All options of extensions */
                //  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                //  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xml();
                //  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Ods();
                //  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Slk();
                //  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Gnumeric();
                //  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                $returnStruct->setResponse([], 'error', 'danger', ['File not supported!']);
                return $returnStruct;
                break;
        }

        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($fullPath);
        $worksheet = $spreadsheet->getActiveSheet();
        $list = $this->getList($worksheet);

        if (!count($list)) {
            $returnStruct->setResponse($list, 'success', 'alert', ['None of the records match expectations!']);
            return $returnStruct;
        }

        $returnStruct->setResponse($list, 'success', 'success', []);
        return $returnStruct;
    }

    private function getList($worksheet) : Array
    {
        $list = [];
        $columnNames = [];
        $countRow = 0;

        foreach ($worksheet->getRowIterator() as $row)
        {
            $columnValues = [];
            $emptyRow = true;
            $countRow += 1;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                                                               //    even if a cell value is not set.
                                                               // For 'TRUE', we loop through cells
                                                               //    only when their value is set.
                                                               // If this method is not called,
                                                               //    the default value is 'false'.
            foreach ($cellIterator as $cell)
            {
                $item = $cell->getValue();

                if ($countRow === 1) {
                    $columnNames[] = $item;
                } else {
                    if ($item) {
                        $emptyRow = false;
                    }

                    $columnValues[] = $item;
                }
            }

            if ($countRow > 1 && !$emptyRow)
            {
                $obj = new \stdClass();

                // construct obj
                foreach ($columnNames as $key => $value)
                {
                    $obj->{Str::of($value)->studly()} = $columnValues[$key];
                }

                $list[] = $obj;
            }
        }

        return $list;
    }
}
