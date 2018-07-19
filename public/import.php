<?
    $pdo = new PDO('mysql:host=localhost;dbname=testmigrationdb', 'testmigration','testmigrationUSER');
    $stmt = $pdo->prepare('UPDATE prices a,availibilities b SET a.enabled=0,a.updated_at=? WHERE b.store_id = 4 AND a.availibility_id = b.id AND a.enabled=1');
    $stmt->execute([date('Y-m-d H:i:s')]);
	$records = file_get_contents('PROD.CSV');
	$records = explode("\n", $records);
	$n = count($records);
	for ($i = 1; $i < $n; $i++) {
        if (count($row) > 18) {
            $row = explode("\t", $records[$i]);
            $name = iconv("cp1251", "utf-8", $row[2]);
            $producer = iconv("cp1251", "utf-8", $row[4]);
            $corpus = iconv("cp1251", "utf-8", $row[3]);
            $code = $row[19];
            $qty = $row[5];
            $price_r = $row[6];
            $q_r = $row[8] - 1;
            $price_m = $row[7];
            $q_m = $row[10] - 1;
            $price_o = $row[9];
            $q_o = 1000000000;
            $name_id = 0;
            $producer_id = 0;
            $corpus_id = 0;
            $product_id = 0;
            $position_id = 0;
            $availibility_id = 0;
            $stmt = $pdo->prepare('SELECT id FROM positions WHERE firm_id = 4 AND code = ?');
            $stmt->execute([$code]);
            if ($stmt->rowCount() == 0) {
                $stmt = $pdo->prepare('SELECT id,name FROM names WHERE name = ?');
                $stmt->execute([$name]);
                if ($stmt->rowCount() == 0) {
                    $stmt = $pdo->prepare('INSERT INTO names (name,alias,created_at,updated_at) values (?,?,?,?)');
                    $stmt->execute([$name, mb_ereg_replace('[^0-9A-Za-zА-Яа-я]', '', $name), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                    $name_id = $pdo->lastInsertId();
                } else {
                    $row = $stmt->fetch();
                    $name_id = $row['id'];
                }
                if (strlen($producer) > 0) {
                    $stmt = $pdo->prepare('SELECT id,name FROM names WHERE name = ?');
                    $stmt->execute([$producer]);
                    $temp_id = 0;
                    if ($stmt->rowCount() == 0) {
                        $stmt = $pdo->prepare('INSERT INTO names (name,alias,created_at,updated_at) values (?,?,?,?)');
                        $stmt->execute([$producer, mb_ereg_replace('[^0-9A-Za-zА-Яа-я]', '', $producer), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                        $temp_id = $pdo->lastInsertId();
                    } else {
                        $row = $stmt->fetch();
                        $temp_id = $row['id'];
                    }
                    $stmt = $pdo->prepare('SELECT id FROM producers WHERE name_id = ?');
                    $stmt->execute([$temp_id]);
                    if ($stmt->rowCount() == 0) {
                        $stmt = $pdo->prepare('INSERT INTO producers (name_id,created_at,updated_at) values (?,?,?)');
                        $stmt->execute([$temp_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                        $producer_id = $pdo->lastInsertId();
                    } else {
                        $row = $stmt->fetch();
                        $producer_id = $row['id'];
                    }
                }
                if (strlen($corpus) > 0) {
                    $temp_id = 0;
                    $stmt = $pdo->prepare('SELECT id,name FROM names WHERE name = ?');
                    $stmt->execute([$corpus]);
                    if ($stmt->rowCount() == 0) {
                        $stmt = $pdo->prepare('INSERT INTO names (name,alias,created_at,updated_at) values (?,?,?,?)');
                        $stmt->execute([$corpus, mb_ereg_replace('[^0-9A-Za-zА-Яа-я]', '', $corpus), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                        $temp_id = $pdo->lastInsertId();
                    } else {
                        $row = $stmt->fetch();
                        $temp_id = $row['id'];
                    }
                    $stmt = $pdo->prepare('SELECT id FROM some_cases WHERE name_id = ?');
                    $stmt->execute([$temp_id]);
                    if ($stmt->rowCount() == 0) {
                        $stmt = $pdo->prepare('INSERT INTO some_cases (name_id,created_at,updated_at) values (?,?,?)');
                        $stmt->execute([$temp_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                        $corpus_id = $pdo->lastInsertId();
                    } else {
                        $row = $stmt->fetch();
                        $corpus_id = $row['id'];
                    }
                }
                $sql = "SELECT id FROM products where name_id = ? and ";
                $req = [$name_id];
                if (strlen($producer) > 0) {
                    $sql .= " producer_id = ? AND ";
                    $req[] = $producer_id;
                } else
                    $sql .= " producer_id is null AND ";
                if (strlen($corpus) > 0) {
                    $sql .= " some_case_id = ?";
                    $req[] = $corpus_id;
                } else $sql .= " some_case_id is null";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($req);
                if ($stmt->rowCount() == 0) {
                    $sql = "INSERT INTO products (name_id";
                    if (strlen($producer) > 0) {
                        $sql .= ",producer_id";
                    }
                    if (strlen($corpus) > 0) {
                        $sql .= ",some_case_id";
                    }
                    $sql .= ",created_at,updated_at) values (?";
                    if (strlen($producer) > 0) {
                        $sql .= ",?";
                    }
                    if (strlen($corpus) > 0) {
                        $sql .= ",?";
                    }
                    $sql .= ",?,?)";
                    $req[] = date('Y-m-d H:i:s');
                    $req[] = date('Y-m-d H:i:s');
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($req);
                    $product_id = $pdo->lastInsertId();
                } else {
                    $row = $stmt->fetch();
                    $product_id = $row['id'];
                }
                $stmt = $pdo->prepare('INSERT INTO positions (firm_id,product_id,code,created_at,updated_at) VALUES (4,?,?,?,?)');
                $stmt->execute([$product_id, $code, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                $position_id = $pdo->lastInsertId();
            } else {
                $row = $stmt->fetch();
                $position_id = $row['id'];
            }
            echo $position_id . ',';
            $stmt = $pdo->prepare('SELECT id FROM availibilities WHERE store_id=4 AND position_id = ?');
            $stmt->execute([$position_id]);
            if ($stmt->rowCount() == 0) {
                if ($position_id == 54469) {
                    echo 'paused,';
                }
                $stmt = $pdo->prepare('INSERT INTO availibilities (store_id,position_id,quantity_free,created_at,updated_at) VALUES (4,?,?,?,?)');
                $stmt->execute([$position_id, $qty, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                $availibility_id = $pdo->lastInsertId();
            } else {
                $row = $stmt->fetch();
                $availibility_id = $row['id'];
                $stmt = $pdo->prepare('UPDATE availibilities SET quantity_free = ? , updated_at = ? WHERE id = ?');
                $stmt->execute([$qty, date('Y-m-d H:i:s'), $availibility_id]);
            }
            $stmt = $pdo->prepare('SELECT id FROM prices WHERE availibility_id=? AND maximum=?');
            $q_r = $q_r > 0 ? $q_r : 1000000000;
            $stmt->execute([$availibility_id, $q_r]);
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch();
                $stmt = $pdo->prepare('UPDATE prices SET enabled=1, value=? ,updated_at=?, price_type_id=2 WHERE id=?');
                $stmt->execute([$price_r, date('Y-m-d H:i:s'), $row['id']]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO prices (availibility_id,valute_id,value,maximum,created_at,updated_at,price_type_id) VALUES (?,1,?,?,?,?,2)');
                $stmt->execute([$availibility_id, $price_r, $q_r, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
            }
            if ($q_r != 1000000000 && $price_m > 0) {
                $stmt = $pdo->prepare('SELECT id FROM prices WHERE availibility_id=? AND maximum=?');
                $q_m = $q_m > 0 ? $q_m : 1000000000;
                $stmt->execute([$availibility_id, $q_m]);
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $stmt = $pdo->prepare('UPDATE prices SET enabled=1, value=? ,updated_at=?, price_type_id=2 WHERE id=?');
                    $stmt->execute([$price_m, date('Y-m-d H:i:s'), $row['id']]);
                } else {
                    $stmt = $pdo->prepare('INSERT INTO prices (availibility_id,valute_id,value,maximum,created_at,updated_at,price_type_id) VALUES (?,1,?,?,?,?,2)');
                    $stmt->execute([$availibility_id, $price_m, $q_m, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                }
                if ($q_m != 1000000000 && $price_o > 0) {
                    $stmt = $pdo->prepare('SELECT id FROM prices WHERE availibility_id=? AND maximum=?');
                    $stmt->execute([$availibility_id, $q_o]);
                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch();
                        $stmt = $pdo->prepare('UPDATE prices SET enabled=1, value=? ,updated_at=?, price_type_id=2 WHERE id=?');
                        $stmt->execute([$price_o, date('Y-m-d H:i:s'), $row['id']]);
                    } else {
                        $stmt = $pdo->prepare('INSERT INTO prices (availibility_id,valute_id,value,maximum,created_at,updated_at,price_type_id) VALUES (?,1,?,?,?,?,2)');
                        $stmt->execute([$availibility_id, $price_o, $q_o, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                    }
                }
            }
        }
    }
?>