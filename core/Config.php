<? 

namespace PParser\Core;

/**
 * Класс конфигурация, основная задача получить данные
 * из конфига и сформировать объект соответствующий
 */
class Config extends Singleton
{

    private $hashmap = [];

    private $fileName = '/config/config.json';

    /**
     * Config constructor.
     */
    protected function __construct()
    {
        $this->hashmap = $this->get();
    }

    /**
     * @param string $key
     * @return string
     */
    public function getValue(string $key): string
    {
        return $this->hashmap[$key];
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setValue(string $key, string $value): void
    {
        $this->hashmap[$key] = $value;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName): string
    {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed|string
     */
     public function get(): mixed
     {
         
         try{
              $path = Helper::getInstance()->replacePath($this->fileName);
              
              if( !is_readable ( $path) ){throw new \ErrorException('Ошибка, файл не удалось прочитать!');}
              
              $data = json_decode(file_get_contents($path),'JSON_OBJECT_AS_ARRAY');
              
              if( !($data) ){throw new \ErrorException('Ошибка, данные не получилось прочитать');}
              
              $this->config = $data;
              
              return $this->config; 
             
         }catch(\ErrorException $e){
             
              return $e->getMessage();
             
         }

    }

}