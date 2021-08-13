<!-- Content Header (Page header) -->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            User list
                        </h3>
                        <div class="card-tools">
                            <?php
                            $this->load->view("Dashbord/usertheme");
                            ?>
                            <button type="button" class="btn btn-primary openmodal">
                            <i class="fas fa-plus"></i>    
                            Add User
                            <!-- data-toggle="modal" data-target="#exampleModal" -->
                            </button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">All User List Table</h3>
                                        <div class="card-tools">
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0" id="datalist">

                                        <table class="table" id="servicetable">
                                            <thead class="text-info">
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Contact Number</th>
                                                <th>Email Id</th>
                                                <th>Password</th>
                                                <th>Gender</th>
                                                <th>Country</th>
                                                <th>State</th>
                                                <th>City</th>
                                                <th>Images</th>
                                                <th>Status</th>
                                                <th>Created_At</th>
                                                <th>Updated_At</th>
                                                <th>ActionS</th>
                                            </thead>
                                        </table>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>