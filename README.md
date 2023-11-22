

## Installation:

 After run ***docker-composer build*** need run command in web container:
 
 ***composer update***

and set permisions for laravel folder:

***chmod -R 777 /var/www/html/***

 App url: http://localhost:8580 Adminer url: http://localhost:6580

In .ENV file need set:

    DB_HOST=db
    DB_USERNAME=root
    DB_PASSWORD=root

Run command: 

***php artisan migrate --seed***

### Laravel user:

    login: Admin@admin.loc
    pass: admin123

### API:
sanctum is used for authorization https://laravel.com/docs/10.x/sanctum

#### methods:
1. Authorization http://localhost:8580/login
2. Get by id GET http://localhost:8580/api/tasks/{id}  
3. Get by id with tree of subtasks for selected task GET http://localhost:8580/api/tasks/{id}?tree=1 
4. Get all tasks GET http://localhost:8580/api/tasks/
    
    #### Filter parmas:<br>***status=todo|done*** - filter by satus<br>
    ***priority={1...5}*** - filter by priority<br>
    ***query=query string*** - full text search by title description<br>
    ***tree={1}*** = add tree of subtasks for everyone selected task<br>

    #### Sort fields:<br>***sort|sort1=createdAt|completedAt|priority*** <br>
    #### Sort direction:<br>***dir|dir1=asc|desc***<br>

5. Delete task by id DELETE http://localhost:8580/api/tasks/{id}
        Post data:
            _method DELETE
            
6. Update task PUT http://localhost:8580/api/tasks/{id}<br>
    Post data:<br>
    ***_method: PUT***<br>
    ***priority: 1...5***<br>
    ***title: string***<br>
    ***description: text***<br>
    ***status: todo|done***<br>
    
7. Change task status PATCH http://localhost:8580/api/tasks/changeStatus/{id}<br>
    Post data:<br>
    ***_method: PATCH***<br>
    ***status todo|done***<br>
            
8. Insert task POST http://localhost:8580/api/tasks	<br>
    Post data:<br>
    ***priority: 1...5***<br>
    ***title: string***<br>
    ***description: text***<br>
    ***parent_id: task id***<br>        
