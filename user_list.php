<?php
include 'include/header.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); 
    exit;
}
?>

<section class="user-list-table">
    <div class="container mt-5 border shadow p-3 mb-5 bg-white rounded">
        <div class="table-responsive">
            <div class="col row d-flex justify-content-between mt-1">
                <h2 class="font-weight-bold">User List - Table</h2>

                <form class="form-inline" action="user_list.php" method="get">
                    <input class="form-control mr-sm-2" type="search" value="<?php echo isset($_GET['searchQuery']) ? $_GET['searchQuery'] : ''; ?>" placeholder="Search" aria-label="Search" id="searchInput" name="searchQuery">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
                </form>

                <button type="button" class="btn btn-primary" id="addUserBtn">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </div>
            <table class="table table-hover mt-3">
                <thead class="sticky-header">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $db = new Database();
                    $where = null;

                    if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
                        $conditions = array(
                            'firstname' => '%' . $_GET['searchQuery'] . '%',
                            'lastname' => '%' . $_GET['searchQuery'] . '%',
                            'email' => '%' . $_GET['searchQuery'] . '%',
                            'phone' => '%' . $_GET['searchQuery'] . '%'
                        );
                        $where[] = $db->prepareWhere($conditions, 'OR', 'LIKE');
                    }

                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = 5;
                    $start = ($page - 1) * $limit;

                    $usersData = $db->list('users', $where, $cond_type, $start, $limit);
                    $users = $usersData['rows'];
                    $totalRows = $usersData['total'];
                    $totalPages = ceil($totalRows / $limit);

                    $i = $start + 1;
                    foreach ($users as $user) {
                        $photoPath = str_replace('../', './', $user->photo);
                        echo "<tr>";
                        echo "<th scope='row'>" . $i . "</th>";
                        echo "<td>" . $user->firstname . "</td>";
                        echo "<td>" . $user->lastname . "</td>";
                        echo "<td>" . $user->email . "</td>";
                        echo "<td>" . $user->phone . "</td>";
                        echo "<td><img src='" . $photoPath . "' class='rounded img-thumbnail' alt='...'></td>";
                        echo "<td>";
                        echo "<div class='btn-group'>";
                        echo "<button type='button' class='btn btn-outline-success rounded editUserBtn' data-userid='" . $user->id . "' data-firstname='" . $user->firstname . "' data-lastname='" . $user->lastname . "' data-email='" . $user->email . "' data-phone='" . $user->phone . "' data-password='" . $user->password . "' data-photo='" . $photoPath . "'><i class='fas fa-edit'></i> </button>";
                        echo "<button type='button' class='btn btn-outline-danger rounded ml-2 deleteUserBtn' data-userid='" . $user->id . "'><i class='fas fa-trash-alt'></i> </button>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }

                    ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php
                    $searchQuery = isset($_GET['searchQuery']) ? "&searchQuery={$_GET['searchQuery']}" : "";
                    $totalPages = ceil($totalRows / $limit);
                    $prevPage = max(1, $page - 1);
                    $nextPage = min($totalPages, $page + 1);
                    echo "<li class='page-item'>";
                    echo "<form method='get' action='user_list.php'>";
                    echo "<input type='hidden' name='page' value='{$prevPage}'>";
                    echo "<input type='hidden' name='limit' value='{$limit}'>";
                    echo "<input type='hidden' name='totalRows' value='{$totalRows}'>";
                    echo "<input type='hidden' name='totalPages' value='{$totalPages}'>";
                    echo "<input type='hidden' name='searchQuery' value='{$_GET['searchQuery']}'>";
                    echo "<button type='submit' class='page-link'>Previous</button>";
                    echo "</form>";
                    echo "</li>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = $page == $i ? 'active' : '';
                        echo "<li class='page-item {$activeClass}'>";
                        echo "<form method='get' action='user_list.php'>";
                        echo "<input type='hidden' name='page' value='{$i}'>";
                        echo "<input type='hidden' name='limit' value='{$limit}'>";
                        echo "<input type='hidden' name='totalRows' value='{$totalRows}'>";
                        echo "<input type='hidden' name='totalPages' value='{$totalPages}'>";
                        echo "<input type='hidden' name='searchQuery' value='{$_GET['searchQuery']}'>";
                        echo "<button type='submit' class='page-link'>{$i}</button>";
                        echo "</form>";
                        echo "</li>";
                    }
                    echo "<li class='page-item'>";
                    echo "<form method='get' action='user_list.php'>";
                    echo "<input type='hidden' name='page' value='{$nextPage}'>";
                    echo "<input type='hidden' name='limit' value='{$limit}'>";
                    echo "<input type='hidden' name='totalRows' value='{$totalRows}'>";
                    echo "<input type='hidden' name='totalPages' value='{$totalPages}'>";
                    echo "<input type='hidden' name='searchQuery' value='{$_GET['searchQuery']}'>";
                    echo "<button type='submit' class='page-link'>Next</button>";
                    echo "</form>";
                    echo "</li>";
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</section>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userform" enctype="multipart/form-data" action="user_list.php">
                    <input type="hidden" name="action" id="action" value="add" />
                    <input type="hidden" name="userId" id="userId" />
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstName" placeholder="Enter First Name">
                            <br><span id="firstname-error" class="error-message"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter Last Name">
                            <br><span id="lastname-error" class="error-message"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                            <br><span id="email-error" class="error-message"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="phone">Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="Ex. +91 xxxx xxx xxx">
                            <br><span id="phone-error" class="error-message"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <br><span id="password-error" class="error-message"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Repeat the Password">
                            <br><span id="cpassword-error" class="error-message"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="photo">Upload Image</label>
                            <input type="file" class="form-control-file border rounded p-1" name="photo" id="photo">
                            <br><span id="photo-error" class="error-message"></span>
                            <img src="" id="photo-preview" style="max-width: 100%; display: none;">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveUserBtn">Save User</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#saveUserBtn").click(function() {
            var formData = new FormData($("#userform")[0]);

            $.ajax({
                url: 'include/ajax.php',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {

                },
                success: function(res) {
                    console.log(res);
                }
            })
        });


        $("#addUserBtn").click(function() {
            var modal = $("#userModal");
            modal.find('.modal-title').text('Add Data');
            modal.find('#action').val('add');
            modal.find('#userId').val('');
            modal.find('#firstName').val('');
            modal.find('#lastName').val('');
            modal.find('#email').val('');
            modal.find('#phone').val('');
            modal.find('#photo-preview').attr('src', '').show();
            modal.modal('show');
            return false;
        })

        $('.editUserBtn').click(function(event) {
            var userId = $(this).data('userid');
            var firstName = $(this).data('firstname');
            var lastName = $(this).data('lastname');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var photo = $(this).data('photo');

            var modal = $("#userModal");
            modal.find('.modal-title').text('Edit Data');
            modal.find('#action').val('edit');
            modal.find('#userId').val(userId);
            modal.find('#firstName').val(firstName);
            modal.find('#lastName').val(lastName);
            modal.find('#email').val(email);
            modal.find('#phone').val(phone);
            modal.find('#photo-preview').attr('src', photo).show();
            modal.modal('show');
            return false;
        });

        $('.deleteUserBtn').click(function(event) {
            var userId = $(this).data('userid');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'include/ajax.php',
                        type: 'post',
                        data: {
                            action: 'delete',
                            userId: userId
                        },
                        beforeSend: function() {},
                        success: function(res) {
                            if (res.startsWith('ok')) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "User has been deleted.",
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete user.",
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: "Error!",
                                text: "Failed to delete user.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?php
include 'include/footer.php';
?>