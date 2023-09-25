<?php 

function getPosts(){
    // We connext to the database
$database = dbConnect();

// We retrieve the 5 last blog posts
$statement = $database->query("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5");

$posts = [];

while (($row = $statement->fetch())){
   $post = [
      'title' => $row['titre'],
      'french_creation_date' => $row['date_creation_fr'],
      'content' => $row['contenu'],
      'identifier' => $row['id']
   ];

   $posts[] = $post;
}

return $posts;
}

function getPost($identifier)
{
$database = dbConnect();
$statement = $database->prepare(
    "SELECT id, titre,contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh:%imin:%ss') AS date_creation FROM billets WHERE id = ? "
);
$statement->execute([$identifier]);

$row = $statement->fetch();
$post = [
    "title" => $row['titre'],
    "french_creation_date" => $row['date_creation'],
    "content" => $row['contenu']
];

return $post;
}

function getComments($identifier)
{
    $database = dbConnect();

    $statement = $database->prepare(
        "SELECT id,author,comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh:%imin:%ss') AS date_creation FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
    );

    $statement->execute([$identifier]);

    $comments = [];
    while (($row = $statement->fetch())){
        $comment = [
            'author' => $row['author'],
            'date_creation' => $row['date_creation'],
            'comment' => $row['comment']
        ];
        $comments[] = $comment;
    }

    return $comments;
}

function dbConnect(){
    try
    {
       $database = new PDO('mysql:host=localhost:8889;dbname=mvc_in_php;charset=utf8', 'root', 'root');
       return $database; 
    }
    catch(Exception $e){
          die( 'Erreur : '.$e->getMessage()   );
    }
}