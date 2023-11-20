<?php
namespace App\DTO;

use App\Models\Task;
use ReflectionClass;


abstract class BaseDto{
    protected static $toCamelCase = true;
    
    protected static function snakeCaseToCamelCase(string $input):string
    {
      $output = str_replace('_', '', ucwords($input, '_'));
      $output = lcfirst($output);
      return $output;
    }

    protected static function camelCaseToSnakeCase(string $input):string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }

    protected static function makeArray(array $data ):array{
       $formData = [];
       
        foreach($data as $name => $value){
            $propertyName = (static::$toCamelCase === true)?self::snakeCaseToCamelCase($name):self::camelCaseToSnakeCase($name);
            $methodName = "";
            
            if(property_exists(static::class,$propertyName)) {
                $methodName = "set".ucfirst(self::snakeCaseToCamelCase($name))."Attribute";
                if(method_exists(static::class,$methodName)){
                    
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
    public static function collection($collectionTask){
        $collection =[];
        foreach($collectionTask as $data){
            if(is_object($data) && method_exists($data,"toArray"))
                $data = $data->toArray();
           
            $collection[] = self::fromArray($data);
        }
        return $collection ;
    }
    public static function fromArray(array $data):static{

        return new static(...self::makeArray($data));
    }

    public function toArray():array{
        return (array)$this;
    }
}