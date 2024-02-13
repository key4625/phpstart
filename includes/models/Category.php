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
    global $RECORDS_PER_PAGE;
    // Get the page via GET request (URL param: page), if non exists default the page to 1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $num_page = ($page-1)*$RECORDS_PER_PAGE;
    // Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
    $stmt = $con->prepare('SELECT * FROM articles where category_id = ? ORDER BY date_created DESC LIMIT ?, ?');
    // Bind the parameters
    $stmt->bind_param('iii', $idCategory, $num_page, $RECORDS_PER_PAGE);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $articles = $stmt->get_result();;
    return $articles->fetch_all(MYSQLI_ASSOC);
}
function show_category_from_slug($slug){
    global $con;
    $stmt = $con->prepare('SELECT * FROM categories WHERE slug = ?');
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $category = $stmt->get_result();
    return $category->fetch_assoc();
}