<!DOCTYPE html>
<html>
    <head>
        <style>table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                border: 1px solid #ddd;
            }

            th, td {
                border: 1px solid #000;
                text-align: left;
                padding: 8px;
            }
        </style> 
    </head>
    <body>
        <table >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Status for <?php echo date('d-m-Y', strtotime(' -1 day')) ?></th>

                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                for ($i = 0; $i < count($data); $i++) {
                    if ($data[$i]['date1'] != 'Absent' && $data[$i]['date1'] == 'NA') {
                        $output[] = $data[$i];
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $data[$i]['empname']; ?></td>
                            <td><?php echo $data[$i]['date1']; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>

        </table>
    </body>
</html>