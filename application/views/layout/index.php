<!DOCTYPE html>
<html>
 <!-- include 'head.php';  -->
<?php
$this->load->view('layout/head');
?>

<body class="hold-transition sidebar-mini layout-fixed">


    <!--  include 'nav.php' -->
    <?php
    $this->load->view('layout/nav');
    ?>
    <!-- Main Sidebar Container -->
    <!-- include 'sidebar.php' -->
    

    <!-- Content Wrapper. Contains page content -->

    <!-- /.content-wrapper -->
    <div class="content-wrapper">
  
            <?php
            // $this->load->view('layout/wrapper');
            ?>
            <?php
                    if (isset($content_view) && $content_view != "") {
                        $this->load->view($content_view);
                    }
                    ?>
            <!-- Control sidebar content goes here -->
      
    </div>

    <!-- //include 'wrapper.php';  -->


    <!-- Control Sidebar -->
    <?php
    $this->load->view('layout/sidebar');
    ?>
   

    <!-- ./wrapper -->
    <?php
    $this->load->view('layout/footer');
    ?>
    <!-- include 'src.php' -->
    <?php
    $this->load->view('layout/src');
    ?>

</body>

</html>