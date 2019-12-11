<?php
if (count($output) > 0):
    ?>
    <pre>
                                                                            <table border="1" style="border-collapse: collapse;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th><?php echo implode('</th><th>', array_keys(current($output))); ?></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                <?php foreach ($output as $row): array_map('htmlentities', $row); ?>
                                                                                                                                                            <tr>
                                                                                                                                                                <td><?php echo implode('</td><td>', $row); ?></td>
                                                                                                                                                            </tr>
                <?php endforeach; ?>
                                                                                </tbody>
                                                                            </table>
    </pre>
    <?php
endif;
?>