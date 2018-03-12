<?php
                    
                        $host = "127.0.0.1";
                        $user = "cianmc85";
                        $pass = "";
                        $db = "project_db";
                        $port = 3306;

                        // Create connection
                        $conn = new mysqli($host, $user, $pass, $db, $port);
                        // Check connection

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        $searchTerm = $_GET['term'];
                        
                        $autocompleteSql = "SELECT school FROM teachers WHERE school LIKE '%".$searchTerm."%'";
                        $autocompleteSqlResult = $conn->query($autocompleteSql);
                        
                        if ($autocompleteSqlResult->num_rows > 0) { 
                            
                            $searchresultsArray = array();
                            
                            while($autocompleteRetrieveRow = $autocompleteSqlResult->fetch_assoc()) {
                                
                                $reviewIDArray[] = $reviewRetrieveSqlRow['school'];
                                
                            }
                            
                            echo json_encode($reviewIDArray);
                        }
                         
                       
                    
                ?>    