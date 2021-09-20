<h1>Assignment  </h1>

1. Retrieve and store data  
Your task is to create a Laravel Package to save into a MySQL DB the list of peoples and the  details about their related planet using an "artisan" command. The list of people and the  information related to a planet can be accessed using the following APIs: 
• GET https://swapi.dev/api/people 
• GET https://swapi.dev/api/planets/{planetId} 
(Full documentation: https://swapi.dev/documentation) 

2. Provide data  
Once you saved people data you have to provide them to an hypothetical frontend via the  following API endpoints: 
• GET /api/people (Provide a paginated list of people, filterable and orderable) • GET /api/people/{peopleId} (Provide selected people data including planet details) 
Stack 
● PHP/Laravel. 
● the usage of docker is a plus 
● build tool of your choice 
● PHPUnit test is a plus 


<h1>Running up the system</h1>
docker-compose up -d

1. Retrieve and store data  
    docker-compose exec myapp php artisan swapi:get
    for rapid clean you can use
        docker-compose exec myapp php artisan swapi:get
2. Provide data
    - localhost:3000/api/people?order=name&height=18
    - localhost:3000/api/people/1
