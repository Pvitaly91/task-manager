<?
namespace App\Repositories;
interface RepositoryInterface{

    function getById(int $id);
    function getByCriteria(array $filter); //get data with specific filter
    function getAll(); 
    function fullTextSearch(string $query);
}