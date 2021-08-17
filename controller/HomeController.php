<?

namespace PParser\Controller;

use PParser\Core\DataBase;
use PParser\Core\Logger;
use PParser\Model\Product;

class HomeController extends Controller
{

    private $products = [];

    public function index()
    {

        $fenom = $this->di->get('Fenom');

        $this->getAListOfProducts();

        if ($this->products) {

            $fenom->display("content.tpl", $this->products);

        } else {

            $fenom->display("content.tpl", array());
        }
    }

    /**
     * Основной метод загрузки и парсинга файла
     * Загружает файл в директорию /template/files/
     * Парсит файл и создает модели Product а основе полученных данных
     * Сохраняет данные в базу данных в таблицу Product
     */
    public function loading()
    {

        $request = $this->di->get('Request');

        $fenom = $this->di->get('Fenom');

        $files = $request->files;

        $server = $request->server;

        try {

            if ($files = $this->uploadFile($files["pricelist"])) {

                if ($csv = $this->parseCsvFile($server['DOCUMENT_ROOT'] . $files[0])) {

                    foreach ($csv as $key => $value) {

                        $product = new Product($value['name'], $value['price']);

                        $obj = $this->save($product);

                        if($obj){

                            $this->products['Products'][] = $obj;
                        }

                    }

                    $result = $fenom->fetch("table-row.tpl", $this->getProducts());

                    print(json_encode(array('Success' => true, 'Message' => 'Файл успешно загружен! Новых продуктов - '.count($this->getProducts()), 'arrResponse' => $result)));

                } else {

                    throw new \ErrorException('Ошибка, не получилось спарсить файл!');
                }
            } else {

                throw new \ErrorException('Ошибка, не получилось загрузить файл!');
            }


        } catch (\ErrorException $e) {

            print(json_encode(array('Success' => false, 'Message' => $e->getMessage(), 'arrResponse' => '')));

        }

    }


    /**
     * @param $file
     * @param string $separator
     * @return array
     */
    public function parseCsvFile($file, $separator = ';'): array
    {

        $csv = array_map('str_getcsv', file($file));

        $data = [];

        array_shift($csv);

        foreach ($csv as $key => $value) {

            $exp = explode($separator, $value[0]);

            $data[$key]['name'] = $exp[0];

            $data[$key]['price'] = $exp[1];

        }

        return $data;
    }

    /**
     * @param array $files
     * @return array
     */
    public function uploadFile(array $files = []): array
    {
        $request = $this->di->get('Request');

        $server = $request->server;

        $result = [];

        foreach ($files["error"] as $key => $error) {

            if ($error == 0) {
                $tmp_name = $files["tmp_name"][$key];

                $name = basename($files["name"][$key]);

                if (move_uploaded_file($tmp_name, $server['DOCUMENT_ROOT'] . '/template/files/' . $name)) {

                    array_push($result, '/template/files/' . $name);
                }

            }

        }

        return $result;
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function save(Product $product): mixed
    {
        $db = $this->di->get('DataBase');

        if(!$this->checkForExistence($product)){

            $query = "INSERT INTO `product`(`name`, `price`) VALUES ({?},{?})";

            $result = $db->query($query, array($product->getName(), $product->getPrice()));

            if ($result) {

                $product->setId($result);

            }
            return $product;

        }else{

            return false;

        }

    }

    /**
     * @param Product $product
     * @return bool
     */
    public function checkForExistence(Product $product): bool
    {
        $db = $this->di->get('DataBase');

        $query = "SELECT * FROM `product` WHERE `name` = {?}";

        $result = $db->select($query,array($product->getName()));

        if($result){

            return true;

        }else{

            return false;
        }
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products['Products'] = $products;
    }

    /**
     * Получает все данные из таблицы Product
     * Создает модели Product на основе полученных данных
     */
    public function getAListOfProducts()
    {
        $db = $this->di->get('DataBase');

        $query = "SELECT * FROM `product` WHERE 1";

        $result = $db->select($query);

        if ($result) {

            foreach ($result as $key => $value) {

                $product = new Product($value['name'], $value['price']);

                $product->setId($value['id']);

                $product->setDate($value['date']);

                $this->products['Products'][] = $product;

            }
        }

    }

}

?>