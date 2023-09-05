<?php
require('connection.php');
$query = mysqli_query($koneksi, "SELECT * FROM nilai");

// data option 
$data = [
  ["option" => "A"],
  ["option" => "B"],
  ["option" => "C"],
  ["option" => "D"],
  ["option" => "E"],
];

// add data
if (isset($_POST['submit'])) {
  $nama = $_POST['nama'];
  $matakuliah = $_POST['matakuliah'];
  $grade = $_POST['grade'];
  $sql = "INSERT INTO nilai (nama, matakuliah, grade) VALUES ('$nama', '$matakuliah', '$grade')";
  $query = mysqli_query($koneksi, $sql);
  header('location:index.php');
}

// edit
if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $matakuliah = $_POST['matakuliah'];
  $grade = $_POST['grade'];
  $sql = "UPDATE nilai SET nama = '$nama', matakuliah = '$matakuliah', grade = '$grade' WHERE id = $id";
  $query = mysqli_query($koneksi, $sql);
  header('location:index.php');
}

// delete
if (!empty($_GET['delete'])) {
  $id = $_GET['delete'];
  $sql = "DELETE FROM nilai WHERE id = $id";
  $query = mysqli_query($koneksi, $sql);
  header('location:index.php');
}

$result = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crud</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
</head>

<body>
  <div class="container mt-5">
    <h2>Gits Tugas ke-5</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Data</button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">tambah data</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="form-tambah-data" action="" method="post">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="nama" id="nama" required>
                <label for="nama">nama</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="matakuliah" id="matakuliah" required>
                <label for="matakuliah">matakuliah</label>
              </div>
              <div class="form-floating">
                <select class="form-select" id="grade" required name="grade">
                  <option value="">Pilih Grade</option>
                  <?php foreach ($data as $key) : ?>
                    <option value="<?= $key['option']; ?>"><?= $key['option']; ?></option>
                  <?php endforeach ?>
                </select>
                <label for="floatingSelect">Grade</label>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit" id="tambah-data">Tambah Data</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <table class="table mt-4">
      <thead>
        <tr>
          <th>Nama</th>
          <th>matakuliah</th>
          <th>grade</th>
          <th>nilai rata-rata</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($result = mysqli_fetch_assoc($query)) : ?>
          <tr>
            <td><?= $result['nama'] ?></td>
            <td><?= $result['matakuliah'] ?></td>
            <td><?= $result['grade'] ?></td>
            <td><?php if ($result['grade'] === 'A') : echo '4.00';
                elseif ($result['grade'] === 'B') : echo '3.00';
                elseif ($result['grade'] === 'C') : echo '2.00';
                elseif ($result['grade'] === 'D') : echo '1.00';
                elseif ($result['grade'] === 'E') : echo '0.00';
                endif; ?></td>
            <td>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModaldetail<?= $result['id']; ?>">Detail</button>
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $result['id']; ?>">Edit</button>
              <a class="btn btn-danger" href="index.php?delete=<?= $result['id'] ?>">Delete</a>
            </td>
            <!-- modal edit -->
            <div class="modal fade" id="exampleModal<?= $result['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="form-tambah-data" action="" method="post">
                      <input type="text" class="form-control" name="id" id="id" value="<?= $result['id'] ?>" hidden>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nama" id="nama" required value="<?= $result['nama'] ?>">
                        <label for="nama">nama</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="matakuliah" id="matakuliah" required value="<?= $result['matakuliah'] ?>">
                        <label for="matakuliah">matakuliah</label>
                      </div>
                      <div class="form-floating">
                        <select class="form-select" id="grade" required name="grade">
                          <?php foreach ($data as $key) : ?>
                            <option value="<?= $key['option']; ?>" <?php echo ($result['grade'] === $key['option']) ? 'selected' : '' ?>><?= $key['option']; ?></option>
                          <?php endforeach ?>
                        </select>
                        <label for="floatingSelect">Grade</label>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="edit" id="tambah-data">Update Data</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- end modal edit -->
            <!-- Moddal detail -->
            <div class="modal fade" id="exampleModaldetail<?= $result['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="form-tambah-data" action="" method="post">
                      <div class="form-floating mb-3">
                        <input disabled type="text" class="form-control" name="nama" id="nama" required value="<?= $result['nama'] ?>">
                        <label for="nama">nama</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input disabled type="text" class="form-control" name="matakuliah" id="matakuliah" required value="<?= $result['matakuliah'] ?>">
                        <label for="matakuliah">matakuliah</label>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-floating">
                            <select class="form-select" id="grade" required name="grade" disabled>
                              <?php foreach ($data as $key) : ?>
                                <option value="<?= $key['option']; ?>" <?php echo ($result['grade'] === $key['option']) ? 'selected' : '' ?>><?= $key['option']; ?></option>
                              <?php endforeach ?>
                            </select>
                            <label for="floatingSelect">Grade</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-floating mb-3">
                            <input disabled type="text" class="form-control" name="matakuliah" id="matakuliah" required value="<?php if ($result['grade'] === 'A') : echo '4.00';
                                                                                                                                elseif ($result['grade'] === 'B') : echo '3.00';
                                                                                                                                elseif ($result['grade'] === 'C') : echo '2.00';
                                                                                                                                elseif ($result['grade'] === 'D') : echo '1.00';
                                                                                                                                elseif ($result['grade'] === 'E') : echo '0.00';
                                                                                                                                endif; ?>">
                            <label for="matakuliah">Nilai Rata-Rata</label>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- end moddal detail -->
          </tr>

        <?php endwhile ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <!-- <script>
    $(document).ready(function() {
      $('#form-tambah-data').submit(function(event) {
        event.preventDefault();
        const nama = $('#nama').val();
        const matakuliah = $('#matakuliah').val();
        const grade = $('#grade option:selected').text()
        const nilaiRataRata = $('#grade').val();

        // ini bisa juga pakai perkondisian tapi yang saya tampilkan ini hanya memaki valuenya saja jika A maka 4 mengikuti berikutnya
        let rataRata;
        switch (grade) {
          case value = 'A':
            rataRata = '4.00';
            break;
          case value = 'B':
            rataRata = '3.00';
            break;
          case value = 'C':
            rataRata = '2.00';
            break;
          case value = 'D':
            rataRata = '1.00';
            break;
          case value = 'E':
            rataRata = '0';
            break;

          default:
            rataRata = '0 '
            break;
        }
        console.log(grade);

        const data = $('<tr>').append(
          $('<td>').text(nama),
          $('<td>').text(matakuliah),
          $('<td>').text(grade),
          $('<td>').text(nilaiRataRata),
          $('<td>').html('<button class="btn btn-danger delete-button">Hapus</button>'));

        $('#isi-data').append(data);
      });
      $('#isi-data').on('click', '.delete-button', function() {
        $(this).closest('tr').remove();
      });
    });
  </script> -->
</body>

</html>