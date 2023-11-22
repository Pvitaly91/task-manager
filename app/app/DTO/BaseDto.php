<?php
namespace App\DTO;

use App\Models\Task;
use ReflectionClass;


abstract class BaseDto{
    protected static $toCamelCase = true;
    
    /**
     * transform snake case string to camel case string
     *
     * @param string $input
     * @return string
     */
    protected static function snakeCaseToCamelCase(string $input):string
    {
      $output = str_replace('_', '', ucwords($input, '_'));
      $output = lcfirst($output);
      return $output;
    }
    /**
     * transform camel case string to snake case string
     *
     * @param string $input
     * @return string
     */
    protected static function camelCaseToSnakeCase(string $input):string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
    /**
     * Make array  for initialization Dto class
     *
     * @param array $data
     * @return array
     */
    protected static function makeArray(array $data ):array{
       $formData = [];
       
        foreach($data as $name => $value){
            $propertyName = (static::$toCamelCase === true)?self::snakeCaseToCamelCase($name):self::camelCaseToSnakeCase($name);
            $methodName = "";
            
            if(property_exists(static::class,$propertyName)) {
                $methodName = "set".ucfirst(self::snakeCaseToCamelCase($name))."Attribute"; //method name like as setPropertyNameAttribute for redefinition input param call in child Dto class
                if(method_exists(static::class,$methodName)){
                    //call set attribute method in child class
                    $reflectionClass = new ReflectionClass(static::class);
                    $reflectionMethod = $reflectionClass->getMethod($methodName);
                    $formData[$propertyName] = $reflectionMethod->invokeArgs(null,[$value]);
                }else{
                    if(is_array($value)){
                        //Add sub-tasks using recursion
                        foreach($value as $subTasks){
                            $formData[$propertyName][] = new static(...self::makeArray($subTasks));
                        }

                    }else{
                        $formData[$propertyName] = $value;
                    }
                } 
            }       
        }
   
        return $formData;
    }
    /**
     * initialization dto class from array and make collection dto classes
     *
     * @param [type] $collectionTask
     * @return void
     */
    public static function collection($collectionTask){
        $collection =[];
        foreach($collectionTask as $data){
            if(is_object($data) && method_exists($data,"toArray"))
                $data = $data->toArray();
           
            $collection[] = self::fromArray($data);
        }
        return $collection ;
    }
    /**
     * initialization one dto class
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data):static{

        return new static(...self::makeArray($data));
    }
    /**
     * transform dto class to array need for using in laravel resource
     *
     * @return array
     */
    public function toArray():array{
        return (array)$this;
    }
}