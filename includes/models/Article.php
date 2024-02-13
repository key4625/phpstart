<?php 

class Article {
    public string $slug;
    public string $title;
    public int $category_id;
    public string $description;
    public string $link_image;
    public string $date_created;
}

function show_articles(){
    global $con;
    global $page;
    global $RECORDS_PER_PAGE;
    // Get the page via GET request (URL param: page), if non exists default the page to 1
    //$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $num_page = ($page-1)*$RECORDS_PER_PAGE;
    // Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
    $stmt = $con->prepare('SELECT * FROM articles ORDER BY date_created DESC LIMIT ?, ?');
    // Bind the parameters
    $stmt->bind_param('ii', $num_page, $RECORDS_PER_PAGE);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $articles = $stmt->get_result();
    
    return $articles->fetch_all(MYSQLI_ASSOC);
}

function count_articles() {
    global $con;
    $stmt = $con->prepare('SELECT COUNT(*) as count FROM articles');
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

function show_article($id){
    global $con;
    $stmt = $con->prepare('SELECT * FROM articles WHERE id = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $article = $stmt->get_result();
    return $article->fetch_assoc();
}

/* get single article from his slug */
function show_article_slug($slug){
    global $con;
    $stmt = $con->prepare('SELECT * FROM articles WHERE slug = ?');
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $article = $stmt->get_result();
    return $article->fetch_assoc();
}

function create_article($title,$description,$link_image,$category_id){
    global $con;
    $nuovo_articolo = new Article();
    $nuovo_articolo->slug = slugify($title);
    $nuovo_articolo->title = $title;
    $nuovo_articolo->description = $description;
    if($link_image != null) {
        $nuovo_articolo->link_image = $link_image;
    } else $nuovo_articolo->link_image = '';
    $nuovo_articolo->category_id = $category_id;
    $nuovo_articolo->date_created = date("Y-m-d H:i:s");
    //aggiungi alla variabile arr_articoli altro oggetto di tipo articolo
    $isDuplicated = false;
    $stmt = $con->prepare('SELECT * FROM articles WHERE slug = ?');
    $stmt->bind_param('s', $nuovo_articolo->slug);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $isDuplicated = true;
    }
    if(!$isDuplicated){
        $stmt = $con->prepare('INSERT INTO articles (slug, title, description, category_id, link_image) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssis', $nuovo_articolo->slug, $nuovo_articolo->title, $nuovo_articolo->description, $nuovo_articolo->category_id, $nuovo_articolo->link_image);
        $stmt->execute();
        return $stmt->affected_rows;
    } else return 2;
}

function update_article($id,$title,$slug,$description,$link_image,$category_id){
    global $con;
    $nuovo_articolo = null;
    $stmt = $con->prepare('SELECT * FROM articles WHERE id = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $nuovo_articolo = $result->fetch_assoc();
    }
    //var_dump($link_image);
    if($nuovo_articolo != null){
        $stmt = $con->prepare('UPDATE articles SET title = ?, slug = ?, description = ?, link_image = ?, category_id = ? WHERE id = ?');
        $stmt->bind_param('ssssii', $title, $slug, $description, $link_image, $category_id, $id);
        $stmt->execute();
        return $stmt->affected_rows;
    } else return 0;
}

function delete_article($id){
    global $con;
    $stmt = $con->prepare('DELETE FROM articles WHERE id = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    return $stmt->affected_rows;
}



