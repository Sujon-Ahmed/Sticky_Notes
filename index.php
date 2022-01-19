<?php
session_start();
require("database.php");
$select_notes = "SELECT * FROM `notes` ORDER BY id DESC";
$notes = mysqli_query($connection, $select_notes);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Sticky Notes</title>
    <!-- custom css link -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <header>
                    <h4 class="text-light fw-bolder">Sticky Notes</h4>
                    <hr class="w-25 text-light">
                    <div class="input-group text-light">
                        <i class="fa fa-search position-absolute text-light"></i>
                        <input type="search" name="search" class="form-control mb-3 position-relative text-light" placeholder="Search..." id="">
                    </div>
                </header>
                <?php foreach ($notes as $note) { ?>
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between bg-info">
                            <span><?= date('M-d-Y h:i A', strtotime($note['created_at'])) ?></span>
                            <span class="actions">
                                <i class="fa fa-ellipsis-h"></i>
                                <div class="act">
                                    <a href="edit.php?id=<?= $note['id'] ?>">Edit Notes</a>
                                    <a name="delete.php?id=<?= $note['id'] ?>" class="delete">Delete Notes</a>
                                </div>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                <?= $note['notes'] ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <header>
                    <h4 class="fw-bolder text-light">Write Your Notes</h4>
                    <hr class="w-50 text-light">
                </header>
                <div class="card shadow-sm">
                    <div class="card-header bg-info"></div>
                    <div class="card-body">
                        <form action="add_note_action.php" method="POST">
                            <div class="form-floating">
                                <textarea class="form-control" name="note" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2" class="text-dark"><i class="fa fa-pencil"></i> New Notes</label>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <input type="submit" name="submit" value="Submit" class="btn btn-info btn-sm mt-3 text-light fw-bold">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jquery cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- bootstrap cdn link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!-- sweet alert cdn link -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- sweet alert  success message -->
    <?php if (isset($_SESSION['success'])) { ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<?= $_SESSION['success'] ?>',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php }
    unset($_SESSION['success']) ?>
    <!-- sweet alert  success message -->
    <?php if (isset($_SESSION['update'])) { ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<?= $_SESSION['update'] ?>',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php }
    unset($_SESSION['update']) ?>
    <!-- sweet alert  required message -->
    <?php if (isset($_SESSION['required'])) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $_SESSION['required'] ?>'
            })
        </script>
    <?php }
    unset($_SESSION['required']) ?>
    <!-- sweet alert  delete message -->
    <script>
        $('.delete').click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var link = $(this).attr('name');
                    window.location.href = link;
                }
            })
        });
    </script>
    <?php if (isset($_SESSION['delete_success'])) { ?>
        <script>
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        </script>
    <?php }
    unset($_SESSION['delete_success']) ?>
</body>

</html>