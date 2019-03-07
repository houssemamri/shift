<?php
/**
  Name: Update Class
  Author: Scrisoft
  Created: 03/07/2016
  This class updates Midrub.
 * */
if (!preg_match("/admin\/update/i", @$_SERVER["HTTP_REFERER"]))
    die();

class Update {

    public $url, $remote_url, $referer, $copied;

    public function __construct() {
        $this->url = str_replace(["update.php", "?cancel=update"], "", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $this->remote_url = "https://www.midrub.com/version-0-0-7-5/";
        $this->referer = str_replace("https", "http", @$_SERVER["HTTP_REFERER"]);
        $this->copied = [];
    }

    public function update_now() {
        if ($this->referer == str_replace('?l='.htmlentities($_GET["l"]),'',$this->url . "admin/update")) {
            if (file_exists("try-update.php")) {
                $ip = file_get_contents("try-update.php");
                @unlink("try-update.php");
                if ($_SERVER['REMOTE_ADDR'] == $ip) {
                    // first delete backup
                    $this->delete_last_backup("backup");
                    // create the backup directory
                    $this->create_dir("backup");
                    $update_url = $this->remote_url . "update.php?l=".htmlentities($_GET["l"]);
                    $update_down = $this->get_contents($update_url);
                    $new_update = "";
                    if ($update_down) {
                        $from = json_decode($update_down, true);
                        if (array_key_exists("files", $from)) {
                            $files = $from["files"];
                            $diru = $from["directory"];
                            foreach ($files as $file) {
                                $file = str_replace($diru."/", "", $file);
                                $cfile = "backup/" . $file;
                                $route = dirname($file);
                                $explode = explode("/", $route . "/");
                                // check if the file is new or old
                                if (file_exists(str_replace(".htm", ".php", $file))) {
                                    if (count($explode) > 1) {
                                        $folder_route = "backup/";
                                        $this->create_directories($explode, $folder_route, $route);
                                        // than copy the file in the created folder									
                                    }
                                    if (!copy(str_replace(".htm", ".php", $file), str_replace(".htm", ".php", $cfile))) {
                                        $this->error_writing();
                                    }
                                    // if will be found an error, will be restore all files
                                    $this->copied[] = str_replace(".htm", ".php", $cfile);
                                }
                                // first will be created the directories if not exists
                                $this->create_directories($explode, "", $route);
                                // then will be copied the file
                                if (!copy($this->remote_url . $diru."/" . $file, str_replace(".htm", ".php", $file))) {
                                    $this->error_writing();
                                }
                                echo '<p class="success">' . str_replace(".htm", ".php", $file) . ' - <span style="color:#03A9F4">success</span></p>';
                            }
                            // update the file update.json with new data
                            $this->put_contents("update.json", $update_down);
                            $this->put_contents("backup/backup.json", json_encode(["files" => @$this->copied], JSON_PRETTY_PRINT));
                            echo '<p class="success">Your website was updated successfully.</p>';
                        }
                    }
                }
            }
        }
    }

    public function cancel_update() {
        // cancel the last update and restore all old files
        if ($this->referer == $this->url . "admin/update") {
            if (file_exists("try-update.php")) {
                $ip = file_get_contents("try-update.php");
                @unlink("try-update.php");
                if ($_SERVER['REMOTE_ADDR'] == $ip) {
                    // check if the backup/backup.json file exists
                    if (file_exists("backup/backup.json")) {
                        // read the backup/backup.json file
                        $backup = $this->get_contents("backup/backup.json");
                        $backup = json_decode($backup, true);
                        if (array_key_exists("files", $backup)) {
                            // extract all files from the backup/backup.json file
                            $files = $backup["files"];
                            $error_check = 0;
                            foreach ($files as $file) {
                                // check if the file exists
                                if (file_exists($file)) {
                                    $cfile = str_replace("backup/", "", $file);
                                    if (!copy($file, $cfile)) {
                                        $error_check++;
                                        echo '<p class="error" style="color:#b71c1c">The file ' . $file . ' wasn\'t restored.</p>';
                                    } else {
                                        echo '<p class="success">' . $file . ' - <span style="color:#03A9F4">success</span></p>';
                                    }
                                } else {
                                    $error_check++;
                                    echo '<p class="error" style="color:#b71c1c">The file ' . $file . ' doesn\'t exists.</p>';
                                }
                            }
                            if ($error_check == 0) {
                                echo '<p class="success">The last updated was cancelled.</p>';
                                // now will be deleted all new created files
                                $read_update_file = $this->get_contents("update.json");
                                if ($read_update_file) {
                                    $backup = json_decode($read_update_file, true);
                                    if (array_key_exists("files", $backup)) {
                                        $bfiles = $backup["files"];
                                        $diru = $backup["directory"];
                                        $error_check = 0;
                                        foreach ($bfiles as $file) {
                                            $cfile = str_replace([$diru."/", ".htm"], ["backup/", ".php"], $file);
                                            if (!in_array($cfile, $files)) {
                                                if (!@unlink(str_replace("backup/", "", $cfile))) {
                                                    echo "<p class=\"error\">" . str_replace("backup/", "", $cfile) . " wasn't deleted. Please, delete it.</p>";
                                                }
                                            }
                                        }
                                    }
                                }
                                // delete backup files
                                $this->delete_last_backup("backup");
                                // delete the update.json file
                                @unlink("update.json");
                            }
                        }
                    } else {
                        echo '<p class="error" style="color:#b71c1c">The file backup/backup.json doesn\'t exists.</p>';
                    }
                }
            }
        }
    }

    public function restore_backup() {
        // check if files were saved in the array $this->copied
        if ($this->copied) {
            // this variable all files that not were restored
            $not_restored = [];
            // next restore them
            foreach ($this->copied as $file) {
                // check if the $file was backuped
                if ($file) {
                    // restore it
                    if (!copy($file, str_replace("backup/", "", $file))) {
                        $not_restored[] = $file;
                    }
                }
            }
            // check if all files was restored
            if (!$not_restored) {
                echo '<p class="error" style="color:#b71c1c">The update process was aborted and all old files were restored.</p>';
            }
        }
        // next, check some of files were not been restored
        if ($not_restored) {
            echo '<h4 class="error">These files were not restored:</h4>';
            foreach ($not_restored as $not) {
                echo '<p class="error">' . $not . ' <em>must be copied here</em> ' . str_replace("backup/", "", $file) . '</p>';
            }
        }
    }

    public function error_writing() {
        $this->restore_backup();
        echo '<p class="error" style="color:#b71c1c">Please, check the file writing permission.</p>';
        die();
    }

    public function create_directories($explode, $folder_route = NULL, $route) {
        if (!is_dir($folder_route . $route)) {
            // creates all directies if not exists
            foreach ($explode as $dir) {
                $folder_route = ($folder_route != NULL) ? $folder_route . "/" . $dir : $dir;
                if (strlen($folder_route) > 0) {
                    $this->create_dir($folder_route);
                }
            }
        }
    }

    public function create_dir($dir) {
        // check if directory already exists
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777)) {
                $this->error_writing();
            }
        }
    }

    public function put_contents($file, $from) {
        if (!file_put_contents($file, $from)) {
            $this->error_writing();
        }
    }

    public function get_contents($file) {
        $context = stream_context_create(array('http' => array('method' => 'GET', 'timeout' => 30),    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    )));
        $content = file_get_contents($file, 0, $context);
        return $content;
    }

    public function delete_last_backup($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        $this->delete_last_backup($dir . "/" . $object);
                    } else {
                        if (!unlink($dir . "/" . $object)) {
                            echo '<p class="error" style="color:#b71c1c">Please, check the file writing permission.</p>';
                            die();
                        }
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

}
?>
<html>
    <head>
        <title><?= isset($_GET["cancel"]) ? 'Restore Reports' : 'Update Reports' ?></title>
        <style>
            a
            {
                color: cornflowerblue;
                text-decoration: initial;	
            }
            a:hover
            {
                text-decoration:underline;	
            }
            h2
            {
                color: #000000;
                font-family: Arial,sans-serif;
                font-weight: bold;
                line-height: 1.1em;
                margin-top: 20px;
            }
            p.success
            {
                line-height: 30px;
                border-radius: 3px;
                padding: 0px 5px;
                font-weight: 500;
                background: #d5e9f6;
                color: #144261;
            }
            p.error
            {
                background: #FFEBEE;
                line-height: 30px;
                border-radius: 3px;
                padding: 0px 5px;
            }
        </style>
    </head>
    <body>
        <?php
        $update = new Update();
        echo isset($_GET["cancel"]) ? '<h2>Restore Reports</h2>' : '<h2>Update Reports</h2>';
        if (isset($_GET["cancel"])) {
            $update->cancel_update();
            echo '<p><a href="' . $update->referer . '">Go Back</a></p>';
        } else {
            $update->update_now();
            echo '<p><a href="' . $update->referer . '">Go Back</a></p>';
        }
        ?>
    </body>
</html>
<?php
/* End of file update.php */
/* Location: ./update.php */