<?php
namespace MVC\Services;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// use MVC\Models\Book;
// use MVC\Models\Category;
// use MVC\Models\GalleryImage;
// use MVC\Models\User;
// use MVC\Models\Rating;
use MVC\Repository\BookRepository;
use MVC\Repository\BranchRepository;
use MVC\Repository\CategoryRepository;
use MVC\Repository\GalleryImageRepository;
use MVC\Repository\CommentRepository;
use MVC\Repository\RatingRepository;
use MVC\Repository\OrderRepository;
use MVC\Repository\ImportRepository;


session_start();

class BookService {

    private static $instance;
    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }
    public function showHomePage(){

        $categories_nav = CategoryRepository::getInstance()->getAllCategories();
        // var_dump($categories_nav);
        
        $categories = CategoryRepository::getInstance()->getInfinityCategory();
        
        $result=[];
        $carts = [];
        
        $cartArray = $_SESSION['cart'];
        
        

        foreach($categories as $category) {
            $books = BookRepository::getInstance()->findByCategoryIdForInfinity($category['category_id']);
            
            $book_display = [];
            //Get gallery images for each book in this category
            foreach($books as $book) {
                $gallery = GalleryImageRepository::getInstance()->findShowByBookId($book['book_id']);
                $book['address'] = $gallery['address'];
                $book_display[] = $book;
            }

            $category['books'] = $book_display;
            $result[] = $category;
        }


        //Get gallery images for each book in cart
        if(!count($cartArray) == 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

        

        return ['categories_nav' => $categories_nav,'categories'=> $result, 'book_cart' => $carts];
    }

    public function getMoreInfinityData($lastID, $limit) {
        $results = BookRepository::getInstance()->getMoreBooksForInfinity($lastID, $limit);
        
        $number_rows = $results[0];
        $number = $results[1];
        $categories = $results[2];
        // var_dump($categories);

        $result=[];

        foreach($categories as $category) {
            $books = BookRepository::getInstance()->findByCategoryIdForInfinity($category['category_id']);
            
            $book_display = [];
            //Get gallery images for each book in this category
            foreach($books as $book) {
                $gallery = GalleryImageRepository::getInstance()->findShowByBookId($book['book_id']);
                $book['address'] = $gallery['address'];
                $book_display[] = $book;
            }

            $category['books'] = $book_display;
            $result[] = $category;
        }

        return ['number_rows' => $number_rows,'categories'=> $result, 'number' => $number];
    }

    public function showFillerCategoryPage($categoryId,$minprice, $maxprice, $page, $limit){

        $current_cate = CategoryRepository::getInstance()->findByCategoryId($categoryId);

        $number_rows = BookRepository::getInstance()->getNumberPageOfCategoryPage($categoryId,$minprice,$maxprice,$limit);

        $books = BookRepository::getInstance()->getByCategoryPagination($categoryId, $minprice, $maxprice, $page);
        $book_display = [];

        foreach($books as $book) {
            $gallery = GalleryImageRepository::getInstance()->findShowByBookId($book['book_id']);
            $book['address'] = $gallery['address'];
            $book_display[] = $book;
        }

        $categories_nav = CategoryRepository::getInstance()->getAllCategories();

        
        $cartArray = $_SESSION['cart'];
        $carts = [];
        //Get gallery images for each book in cart
        if(!count($cartArray) == 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

    
        return ['categories' => $categories_nav,'books'=> $book_display, 
                'book_cart' => $carts,
                'current_cate' => $current_cate, 'category_id' => $categoryId,
                'number_page' => $number_rows,];
    }

    public function showFilterSearchPage($searchKeyword,$minprice, $maxprice, $page, $limit){
        $number_rows = BookRepository::getInstance()->getNumberPageOfFilterPage($searchKeyword,$minprice,$maxprice,$limit);

        $books = BookRepository::getInstance()->getByFilterPagination($searchKeyword, $minprice, $maxprice, $page);
        $book_display = [];

        foreach($books as $book) {
            $gallery = GalleryImageRepository::getInstance()->findShowByBookId($book['book_id']);
            $book['address'] = $gallery['address'];
            $book_display[] = $book;
        }


        $categories_nav = CategoryRepository::getInstance()->getAllCategories();

        
        $cartArray = $_SESSION['cart'];
        $carts = [];

        //Get gallery images for each book in cart
        if(!count($cartArray) == 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }
        

    
        return ['categories' => $categories_nav,'books'=> $book_display, 
                'book_cart' => $carts,
                'number_page' => $number_rows,];
    }

    public function showDetailProductPage($bookId,$userId){
        $categories = CategoryRepository::getInstance()->getAllCategories();

        $book = BookRepository::getInstance()->findById($bookId);
        // HOT ITEM AND IMAGE
        $hotItems = BookRepository::getInstance()->getAllHotItem($bookId);
        $books_hot = GalleryImageRepository::getInstance()->getImageBooks($hotItems);

        // SAME ITEM AND IMAGE
        $sameCategoryItems = BookRepository::getInstance()->getAllSameCategoryItem($bookId,$book['category_id']);
        $books_same_type = GalleryImageRepository::getInstance()->getImageBooks($sameCategoryItems);
 
        
        // ALL COMMENTS AND COUNT COMMENTS
        $comments = CommentRepository::getInstance()->getAllCommentsByBookId($book['book_id']);
        $count_cmt = CommentRepository::getInstance()->getCountCommentsByBookId($book['book_id']);
        

        // ALL REPLIES OF THIS BOOK
        $replies = CommentRepository::getInstance()->getAllRepliesByBookId($book['book_id']);

        //ALL RATINGS ANDC COUNR RATINGS

        $count_rate = RatingRepository::getInstance()->getCountRatingsByBookId($book['book_id']);
        $rating = RatingRepository::getInstance()->getAllRatingsByBookId($book['book_id']);

        // RATING OF USER IN CURRENT 
        
        $rate_of_user = RatingRepository::getInstance()->findRateByBookIdAndUserId($book['book_id'],$userId);

        // ALL BRANCHES WITH STOCK OF BOOK
        $branchs = BranchRepository::getInstance()->getAllBranchesByBookId($book['book_id']);
        

        // ALL ITEMS IN CART
        $cartArray = $_SESSION['cart'];

        //Get gallery images for each book in cart
        if(!count($cartArray) == 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

    
        // Get gallery images for this book 
        $images = GalleryImageRepository::getInstance()->getAllImagesByBookId($bookId);

        // GET CURRENT IMAGE OF THIS BOOK
        $image_current = GalleryImageRepository::getInstance()->findDefaultImageByBookId($bookId);

        return ['books_hot'=>$books_hot,'book_id'=>$book['book_id'],
                'books_same_type'=>$books_same_type,'categories'=>$categories,
                'count_cmt'=>$count_cmt,'comments'=>$comments,
                'count_rate'=>$count_rate,'rating'=>$rating,
                'rate_of_user'=>$rate_of_user,'branchs'=>$branchs,
                'book_cart'=>$carts,'images'=>$images,
                'image_current'=>$image_current,'replies'=>$replies,
                'book'=>$book];
    }

    public function showHeader(){
        $categories = CategoryRepository::getInstance()->getAllCategories();
        $cartArray = $_SESSION['cart'];
        $carts = [];
        //Get gallery images for each book in cart
        if(!count($cartArray) == 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

        return ['categories'=> $categories,'carts'=>$carts];
    }

    public function showProductManagementPage($searchKeyword,$page,$limit){
        

        $number_page = BookRepository::getInstance()->getNumberPageOfProductManagementPage($searchKeyword,$limit);
        $books = BookRepository::getInstance()->getByProductManagmentPagination($searchKeyword,$page,$limit);
        $books = GalleryImageRepository::getInstance()->getImageBooks($books);


        return ['number_page' =>$number_page, 'books' =>$books];
    }

    public function showAddNewProductPage(){
        $categories = CategoryRepository::getInstance()->getAllCategories();
        return ['categories'=> $categories];
    }
    
    public function addNewProduct($image,$name,$quantity,$price,
                                    $hotItem,$categoryId,$authors,$description,$files)
    {
        $isValid = true;
        
        if(BookRepository::getInstance()->checkExistenceBook($name)){
            $_SESSION['message'] = "PRODUCT'S NAME : ".$name." EXISTED";
            $isValid = false;
        } else if($quantity && $quantity < 0){
            $_SESSION['message'] .= "</br>QUANTITY CANNOT BE NEGATIVE";
            $isValid = false;
        } else if($price && $price < 1000){
            $_SESSION['message'] .= "</br>PRICE CANNOT BE NEGATIVE";
            $isValid = false;
        }

        if($isValid){
            if($files["book-image"]["name"] != null){
                $target_dir = "public/assets/img/";
                $target_file = $target_dir . basename($files["book-image"]["name"]);
        
                echo $target_file;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
                // Kiểm tra file có phải là hình ảnh thật hay không
                $check = getimagesize($files["book-image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['message'] = "File is not an image.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu file đã tồn tại
                if (file_exists($target_file)) {
                    // echo "Sorry, file already exists.";
                    // $uploadOk = 0;
                } else {
                    move_uploaded_file($files["book-image"]["tmp_name"], $target_dir);
                }
        
                // Giới hạn kích thước file
                if ($files["image"]["size"] > 500000) {
                    $_SESSION['message'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
        
                // Giới hạn loại file
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu $uploadOk là 0 do có lỗi
                if ($uploadOk == 0) {
                    $_SESSION['message'] .= "<br>Add Product failed, please try again.";
                    
                // Nếu mọi thứ đều ổn, thử upload file
                } else {
                        echo "The file ". basename( $files["book-image"]["name"]). " has been uploaded.";
                
                        $book_id = BookRepository::getInstance()->addNewBook($name, $quantity, $price, $hotItem, $categoryId, $authors, $description,0);
        
                        $isAddGallery = GalleryImageRepository::getInstance()->addNewGalleryOfBook($target_file,$book_id,1);
                        if($isAddGallery)
                        {
                            $_SESSION['message'] = 'Thêm mới sản phẩm thành công';
                        }
                        else
                        {
                            $_SESSION['message'] = 'Thêm mới sản phẩm thất bại';
                        }
                        
                }
            } else {
                $book_id = BookRepository::getInstance()->addNewBook($image, $name, $quantity, $price, $hotItem, $categoryId, $authors, $description);
                if($book_id){
                    $_SESSION['message'] = 'Thêm mới sản phẩm thành công';
                    
                } else {
                    $_SESSION['message'] = 'Thêm mới sản phẩm thất bại';
                    
                }
            }
            
        } else {
            
        }
        
    }

    public function showEditProductPage($bookId){
        $categories = CategoryRepository::getInstance()->getAllCategories();
        $book = BookRepository::getInstance()->findById($bookId);
        $branches = BranchRepository::getInstance()->getAllBranchesByBookId($bookId);
        $images = GalleryImageRepository::getInstance()->getAllImagesByBookId($bookId);
        return ['categories'=> $categories,'book'=>$book,
                'branches'=>$branches,'images'=>$images];
    }

    public function editProduct($image,$name,$quantity,$price,
                                $hotItem,$categoryId,$authors,
                                $description,$sale,$bookId)
    {
        $isValid = true;
        if(BookRepository::getInstance()->checkExistenceBookById($name, $bookId)){
            $_SESSION['message'] = "PRODUCT'S NAME : ".$name." EXISTED";
            $isValid = false;
        } else if($quantity && $quantity < 0){
            $_SESSION['message'] .= "</br>QUANTITY CANNOT BE NEGATIVE";
            $isValid = false;
        } else if($price && $price < 1000){
            $_SESSION['message'] .= "</br>PRICE CANNOT BE NEGATIVE";
            $isValid = false;
        } else if ($sale && $sale > 100 && $sale <0){
            $_SESSION['message'] .= "</br>SALE CANNOT BE LESS THAN 0 OR MORE THAN 100";
            $isValid = false;
        }

        if($isValid){
            $isUpdateBook = BookRepository::getInstance()->updateBook($name,$quantity,$price,$hotItem,$categoryId,$authors,$description,$sale,$bookId);

            if($isUpdateBook && $image != '' && $image != null){
                GalleryImageRepository::getInstance()->updateDefaultGalleryOfBook($bookId,$image);
                $_SESSION['message'] = 'Cập nhật sản phẩm thành công';
            } else if($isUpdateBook){
                $_SESSION['message'] = 'Cập nhật sản phẩm thành công';
            } else {
                $_SESSION['message'] = 'Cập nhật sản thất bại';
            }
        } else {

        }
            

    }

    public function deleteProduct($bookId){
        if(!OrderRepository::getInstance()->checkByBookId($bookId)){
            $isDeleteBook = BookRepository::getInstance()->deleteById($bookId);
            var_dump($isDeleteBook);
            if($isDeleteBook){
                $_SESSION['message'] = 'Xóa sản phẩm thành công';
            } else {
                $_SESSION['message'] = 'Xóa sản phẩm thất bại';
            }
        } else {
            $_SESSION['message'] = 'Xóa sản phẩm thất bại';
        }

    }

    public function addProductByFile($file){
        $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 

        if(!empty($file['fileimport']['name']) && in_array($file['fileimport']['type'], $excelMimes)){ 
            if(is_uploaded_file($file['fileimport']['tmp_name'])){
                $reader = new XlsxReader(); 
                $spreadsheet = $reader->load($file['fileimport']['tmp_name']); 
                $worksheet = $spreadsheet->getActiveSheet();  
                $worksheet_arr = $worksheet->toArray(); 
                unset($worksheet_arr[0]);
                
                foreach($worksheet_arr as $row){
                    if($row[0] != null || $row[0] != ''){
                        if(BookRepository::getInstance()->checkExistenceBook($row[0])){
                            $this->updateBook($row[0],$row[1],$row[2],$row[3],
                                $row[4],$row[5],$row[6],$row[7]);
                        } else {
                            echo 'test';
                            $this->addBook($row[0],$row[1],$row[2],$row[3],
                                            $row[4],$row[5],$row[6],$row[7]);
                        }
                    }
                }

                $_SESSION['message'] = 'Nhập dữ liệu thành công';
            } else {
                $_SESSION['message'] = 'Nhập dữ liệu thất bại';
            }
        } else {
            $_SESSION['message'] = 'Nhập dữ liệu thất bại';
        }
    }

    public function addBook($title,$description,$category,$price,$authors,$quantity,$hotItem,$sale){
        $categoryId = CategoryRepository::getInstance()->findCategoryExistence($category);
        $quantity = intval($quantity);
        $price = floatval($price);
        $hotItem = intval($hotItem);
        $sale = floatval($sale);

        if($quantity == '' || $quantity == null || $quantity < 0){
            var_dump($quantity);
            $quantity = 0;
        }
        if($price == '' || $price < 1000.0 || $price == null) {
            $price = 1000.0;
        }

        if($hotItem == '' || $hotItem == null || $hotItem > 1 || $hotItem <0){
            $hotItem = 0;
        }

        if($sale == '' || $sale == null || $sale < 0.0 || $sale > 100.0){
            $sale = 0.0;
        }

        BookRepository::getInstance()->addNewBook($title, $quantity, $price, $hotItem, $categoryId, $authors, $description,$sale);
    }

    public function updateBook($title,$description,$category,$price,$authors,$quantity,$hotItem,$sale){
        $book = BookRepository::getInstance()->findByName($title);
        $quantity = intval($quantity);
        $price = floatval($price);
        $hotItem = intval($hotItem);
        $sale = floatval($sale);

        if($quantity == '' || $quantity == null || $quantity < 0){
            var_dump($quantity);
            $quantity = 0;
        }
        if($price == '' || $price < 1000.0 || $price == null) {
            $price = 1000.0;
        }

        if($hotItem == '' || $hotItem == null || $hotItem > 1 || $hotItem <0){
            $hotItem = 0;
        }

        if($sale == '' || $sale == null || $sale < 0.0 || $sale > 100.0){
            $sale = 0.0;
        }
        $categoryId = CategoryRepository::getInstance()->findCategoryExistence($category);

        BookRepository::getInstance()->updateBook($title,$quantity,$price,$hotItem,$categoryId,$authors,$description,$sale,$book['book_id']);
        
    }

    public function exportListAllOfProduct(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header of the Excel file
        $headers = array('Tên sách', 'Mô tả', 'Thể loại', 'Giá bán', 'Tác giả', 'Số lượng', 'Hiện trang chủ','Giảm giá');
        $sheet->fromArray($headers, NULL, 'A1');

        $date = $_GET['date_select'];
        if ($date != null) {
            $timestamp = strtotime($date);
        } else {
            $timestamp = strtotime(date('Y-m-d'));
        }

        $dateFrom = date('Y-m-01 00:00:00', $timestamp);
        $dateTo  = date('Y-m-t 23:59:59', $timestamp);

        $books = BookRepository::getInstance()->getAllBooks();

        // Populate the data into the spreadsheet
        $rowNum = 2; // Start from the second row since the first row is the header
        foreach ($books as $book) {
            $sheet->setCellValue('A' . $rowNum, $book['title']);
            $sheet->setCellValue('B' . $rowNum, $book['description']);
            $sheet->setCellValue('C' . $rowNum, $book['name_category']);
            $sheet->setCellValue('D' . $rowNum, $book['price']);
            $sheet->setCellValue('E' . $rowNum, $book['authors']);
            $sheet->setCellValue('F' . $rowNum, $book['stock']);
            $sheet->setCellValue('G' . $rowNum, $book['hotItem']);
            $sheet->setCellValue('H' . $rowNum, $book['sale']);
            $rowNum++;
        }

        // Generate the Excel file
        $fileName = "codexworld_export_data-" . date('Ymd') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer = new XlsxWriter($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    public function showHotItemPage($searchKeyword,$page,$limit,$date){
        
        if($date != null){
            $timestamp = strtotime($date);
        } else {
            $timestamp = strtotime(date('Y-m-d'));
        }
        $dateFrom = date('Y-m-01 00:00:00', $timestamp);
        $dateTo  = date('Y-m-t 23:59:59', $timestamp);

        $number_page = BookRepository::getInstance()->getNumberPageOfHotItemManagementPage($searchKeyword,$limit);

        $import_min = ImportRepository::getInstance()->findFirstImportInMonth($dateTo);

        $importId = $import_min['min_id'];

        $books = BookRepository::getInstance()->getAllByHotItemPagination($searchKeyword,$page,$limit,$dateTo,$dateFrom,$importId);

        $books_hot = GalleryImageRepository::getInstance()->getImageBooks($books);

        return ['books'=>$books_hot, 'number_page' => $number_page];
    }

    public function exportListAllOfHotItems($date){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header of the Excel file
        $headers = array('ID', 'Tên sách', 'Tác giả', 'Số Lượng', 'Thể loại', 'Giá bán', 'Số lượng đã bán');
        $sheet->fromArray($headers, NULL, 'A1');

        if ($date != null) {
            $timestamp = strtotime($date);
        } else {
            $timestamp = strtotime(date('Y-m-d'));
        }

        $dateFrom = date('Y-m-01 00:00:00', $timestamp);
        $dateTo  = date('Y-m-t 23:59:59', $timestamp);

        $books = BookRepository::getInstance()->getAllHotItemsInMonth($dateTo,$dateFrom);

        // Populate the data into the spreadsheet
        $rowNum = 2; // Start from the second row since the first row is the header
        foreach ($books as $book) {
            $sheet->setCellValue('A' . $rowNum, $book['book_id']);
            $sheet->setCellValue('B' . $rowNum, $book['title']);
            $sheet->setCellValue('C' . $rowNum, $book['authors']);
            $sheet->setCellValue('D' . $rowNum, $book['stock']);
            $sheet->setCellValue('E' . $rowNum, $book['name_category']);
            $sheet->setCellValue('F' . $rowNum, $book['price']);
            $sheet->setCellValue('G' . $rowNum, $book['total']);
            $rowNum++;
        }

        // Generate the Excel file
        $fileName = "codexworld_export_data-" . date('Ymd') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer = new XlsxWriter($spreadsheet);
        $writer->save('php://output');

        exit();
    }
    
}


