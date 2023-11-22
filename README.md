

## Installation:

 After run ***docker-composer build*** need run command in web conatainer:
 
 ***composer update***

and set permisions for laravel folder:

***chmod -R 777 /var/www/html/***

 App url: http://localhost:8580 Adminer url: http://localhost:6580

in .ENV file need set:

    DB_HOST=db
    DB_USERNAME=root
    DB_PASSWORD=root

run command: 

***php artisan migrate --seed***

### laravel user:

    login: Admin@admin.loc
    pass: admin123

### API:
sanctum is used for authorization https://laravel.com/docs/10.x/sanctum

#### methods:
1. Authorization http://localhost:8580/login
2. Get by id GET http://localhost:8580/api/tasks/{id}  
3. Get by id with tree of subtasks for selected task GET http://localhost:8580/api/tasks/{id}?tree=1 
4. get all tasks GET http://localhost:8580/api/tasks/
    
    #### filter parmas:<br>***status=todo|done*** - filter by satus<br>
    ***priority={1...5}*** - filter by priority<br>
    ***query=query string*** - full text search by title description<br>
    ***tree={1}*** = add tree of subtasks for everyone selected task<br>

    #### Sort fields:<br>***sort|sort1=createdAt|completedAt|priority*** <br>
    #### Sort direction:<br>***dir|dir1=asc|desc***<br>

5. delete task by id DELETE http://localhost:8580/api/tasks/{id}
        post data:
            _method DELETE
            
6. update task PUT http://localhost:8580/api/tasks/{id}<br>
    post data:<br>
    ***_method: PUT***<br>
    ***priority: 1...5***<br>
    ***title: string***<br>
    ***description: text***<br>
    ***status: todo|done***<br>
    
7. change task status PATCH http://localhost:8580/api/tasks/changeStatus/{id}<br>
    post data:<br>
    ***_method: PATCH***<br>
    ***status todo|done***<br>
            
8. insert task POST http://localhost:8580/api/tasks	<br>
    ***priority: 1...5***<br>
    ***title: string***<br>
    ***description: text***<br>
    ***parent_id: task id***<br>        
