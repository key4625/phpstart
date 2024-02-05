<?php
class Category {
    public int $id;
    public string $title;
    public string $slug;
    public int $parent_id;  
}

 /*  Mostra tutti gli articoli di una categoria */
 function show_category_articles(int $idCategory) {
    global $con;
    global $page;
    global $records_per_page;
    // Get the page via GET request (URL param: page), if non exists default the page to 1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $num_page = ($page-1)*$records_per_page;
    // Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
    $stmt = $con->prepare('SELECT * FROM articles where category_id = ? ORDER BY date_created DESC LIMIT ?, ?');
    // Bind the parameters
    $stmt->bind_param('iii', $idCategory, $num_page, $records_per_page);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $articles = $stmt->get_result();;
    return $articles->fetch_all(MYSQLI_ASSOC);
}