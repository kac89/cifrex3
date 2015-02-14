//  
//    cIFrex Tool for Static Code Analysis
//    Copyright (C) 2015 cIFrex Team
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see http://www.gnu.org/licenses/.
//

$appka = angular.module('ui.bootstrap.demo', ['ui.bootstrap']);

angular.module('ui.bootstrap.demo').controller('cifrexApp', function ($scope, $modal, $log, $http) {        

    $scope.resId = '';
    $scope.files="";
	$scope.filters='';
    $scope.filter='';
    
	$http.get('filters/read.php').success(function(data) {
          $scope.filters = data;
    });
    $scope.languages='';
	$http.get('languages/read.php').success(function(data) {
          $scope.languages = data;
    });
    $scope.groups='';
	$http.get('groups/read.php').success(function(data) {
          $scope.groups = data;
    });
    $scope.result='';
	$http.get('others/results-general.php').success(function(data) {
          $scope.results = data;
    });
  
    // sorty by
	$scope.predicate = '-date';
    
	// SAVE FILTER 
	$scope.items = {'name' : "", 'cwe' : "", 'cve' : "", 'author' : "", 'lang' : "0", 'group' : "", 'path' : "/www/code/1010/xnu/"};
	
	$scope.vValues = {'v1' : "", 'v2' : "", 'v3' : ""};
	$scope.tValues = {'t1' : "", 't2' : "", 't3' : ""};
	$scope.fValues = {'f1' : "", 'f2' : "", 'f3' : ""};
    //DELETE FILTER
	$scope.remove = {'id' : "", 'name' : ""};
    
    $scope.item_group = {'group_id' : "", 'name' : "", 'description' : "", 'files' : "", 'custom_files' : ""};
    $scope.item_lang = {'lang_id' : "", 'name' : "", 'description' : "", 'files' : ""};
    $scope.selected_lang = {'lang_id' : "0", 'name' : "Default", 'description' : "None", 'files' : "*"};
    $scope.selected_group = {'lang_id' : "", 'name' : "Select Group", 'description' : "None", 'files' : "*"};

    $scope.saveToDb = 'True';
    $scope.debugLog = 'False';
    
    $scope.changeSaveToDb = function ($txt) {
        $scope.saveToDb = $txt;
    };
    
    $scope.changeDebugLog = function ($txt) {
        $scope.debugLog = $txt;
    };
    
<!------------ LICENSE ------------!>
  $scope.license = function (size) {
    var modalInstance = $modal.open({
      templateUrl: 'license.html',
      controller: 'LicenseWeb',
      size: size,
      resolve: {}
    });
  };
  
<!------------ ABOUT ------------!>
  $scope.about = function (size) {
    var modalInstance = $modal.open({
      templateUrl: 'about.html',
      controller: 'AboutWeb',
      size: size,
      resolve: {}
    });
  };
  
<!------------ SAVE FILTER ------------!>
  $scope.saveFilter = function (size) {
      $scope.items.nameOfPage = "Save Pattern";

    var modalInstance = $modal.open({
      templateUrl: 'saveFilter.html',
      controller: 'SaveFilter',
      size: size,
      resolve: {
        items: function () {
          return $scope.items;
        },
        vValues: function () {
          return $scope.vValues;
        },
        tValues: function () {
          return $scope.tValues;
        },
        fValues: function () {
          return $scope.fValues;
        },
        languages: function () {
          return $scope.languages;
        },
        groups: function () {
          return $scope.groups;
        },
        selected_lang: function () {
          return $scope.selected_lang;
        },
        selected_group: function () {
          return $scope.selected_group;
        }
      }
    });
  };
    <!------------ SAVE LANG ------------!>
  $scope.saveLang = function (size) {
      $scope.item_lang.nameOfPage = "Save Language";

    var modalInstance = $modal.open({
      templateUrl: 'saveLang.html',
      controller: 'SaveLang',
      size: size,
      resolve: {
        items: function () {
          return $scope.items;
        },
        item_lang: function () {
          return $scope.item_lang;
        }
      }
    });
  };
    <!------------ SAVE GROUP ------------!>
  $scope.saveGroup = function (size) {
      $scope.item_group.nameOfPage = "Save Group";

    var modalInstance = $modal.open({
      templateUrl: 'saveGroup.html',
      controller: 'SaveGroup',
      size: size,
      resolve: {
        items: function () {
          return $scope.items;
        },
        item_group: function () {
          return $scope.item_group;
        }
      }
    });
  };
});

<!------------ LICENSE ------------!>
angular.module('ui.bootstrap.demo').controller('LicenseWeb', function ($scope, $modalInstance) {
  $scope.ok = function () {
    $modalInstance.close();
  };
});
<!------------ ABOUT ------------!>
angular.module('ui.bootstrap.demo').controller('AboutWeb', function ($scope, $modalInstance) {
  $scope.ok = function () {
    $modalInstance.close();
  };
});
<!------------ SAVE FILTER ------------!>
angular.module('ui.bootstrap.demo').controller('SaveFilter', function ($scope, $modalInstance, items, vValues, tValues, fValues, languages, groups, selected_lang, selected_group){

    $scope.items = items;
    $scope.vValues = vValues;
    $scope.tValues = tValues;
    $scope.fValues = fValues;
    $scope.languages = languages;
    $scope.groups = groups;
    $scope.selected_lang = selected_lang;
    $scope.selected_group = selected_group;

    $scope.ok = function () {
        if($scope.vValues.v1==""){
            alert("Requied V1 pattern!");
            return 0;
        }

         if($scope.items.name==""){
            alert("Please provide name!");
            return 0;
        }

        if($scope.items.lang==""){
            alert("Please provide lang!");
            return 0;
        }

        var data = "name="+encodeURIComponent($scope.items.name)+"&author="+encodeURIComponent($scope.items.author)+"&cwe="+encodeURIComponent($scope.items.cwe)+"&cve="+encodeURIComponent($scope.items.cve)+"&path="+encodeURIComponent($scope.items.path)+"&lang="+encodeURIComponent($scope.items.lang)+"&group="+encodeURIComponent($scope.items.group)+"&v1="+encodeURIComponent($scope.vValues.v1)+"&v2="+encodeURIComponent($scope.vValues.v2)+"&v3="+encodeURIComponent($scope.vValues.v3)+"&t1="+encodeURIComponent($scope.tValues.t1)+"&t2="+encodeURIComponent($scope.tValues.t2)+"&t3="+encodeURIComponent($scope.tValues.t3)+"&f1="+encodeURIComponent($scope.fValues.f1)+"&f2="+encodeURIComponent($scope.fValues.f2)+"&f3="+encodeURIComponent($scope.fValues.f3)+"&lang="+selected_lang.lang_id+"&group="+selected_group.group_id+"";
     
        $.post('filters/save.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
            alert("Success. Filtr stored in database.");
            location.reload();            
        }).error(function(data, status, headers, config) {
            alert("Error. Not saved! Check error log ");
        });;
        
        $modalInstance.close();
  };

  $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
  };
});
<!------------ SAVE GROUP ------------!>
angular.module('ui.bootstrap.demo').controller('SaveGroup', function ($scope, $modalInstance, items, item_group){

    $scope.item_group = item_group;
    $scope.items = items;

    $scope.ok = function () {
        if($scope.item_group.name==""){
            alert("Empty name filed!");
            return 0;
        }
        
        if($scope.item_group.description==""){
            alert("Empty desciption filed!");
            return 0;
        }
        
        if($scope.item_group.path==""){
            alert("Empty path filed!");
            return 0;
        }
        
        if($scope.item_group.custom_files==""){
            alert("Empty files filed!");
            return 0;
        }

        var data = "name="+encodeURIComponent($scope.item_group.name)+"&description="+encodeURIComponent($scope.item_group.description)+"&path="+encodeURIComponent($scope.item_group.path)+"&custom_files="+encodeURIComponent($scope.item_group.name)+"&source="+$scope.item_group.source+"";
     
        $.post('groups/save.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
            alert("Success. Filtr stored in database.");
            location.reload();            
        }).error(function(data, status, headers, config) {
            alert("Error. Not saved! Check error log ");
        });;
        
        $modalInstance.close();
  };

  $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
  };
});
<!------------ SAVE LANG ------------!>
angular.module('ui.bootstrap.demo').controller('SaveLang', function ($scope, $modalInstance, items, item_lang){

    $scope.item_lang = item_lang;
    $scope.items = items;

    $scope.ok = function () {
        
        if($scope.item_lang.name==""){
            alert("Empty name field!");
            return 0;
        }
        
        if($scope.item_lang.description==""){
            alert("Empty description field!");
            return 0;
        }
        
        if($scope.item_lang.files==""){
            alert("Empty files field!");
            return 0;
        }

        var data = "name="+encodeURIComponent($scope.item_lang.name)+"&description="+encodeURIComponent($scope.item_lang.description)+"&files="+encodeURIComponent($scope.item_lang.files)+"";
        
        $.post('languages/save.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
            alert("Success. Lang stored in database.");
            location.reload();            
        }).error(function(data, status, headers, config) {
            alert("Error. Not saved! Check error log ");
        });;
        
        $modalInstance.close();
  };

  $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
  };
});

<!------------ FILTERS PAGE CONTROLER ------------!>
angular.module('ui.bootstrap.demo').controller('editFilterCtrl', function ($scope, $modal, $log, $filter){

    $scope.extratext = {'what':"Remove Pattern"};
    $scope.items = {'name' : "", 'cwe' : "", 'cve' : "", 'author' : "", 'lang' : "0", 'group' : "", 'path' : "/", 'nameOfPage' : 'cIFrex'};
	
	$scope.vValues = {'v1' : "", 'v2' : "", 'v3' : ""};
	$scope.tValues = {'t1' : "", 't2' : "", 't3' : ""};
	$scope.fValues = {'f1' : "", 'f2' : "", 'f3' : ""};
  
    $scope.items.id = $scope.filter.id;
    $scope.items.name = $scope.filter.title;
    $scope.items.cwe = $scope.filter.cwe;
    $scope.items.cve = $scope.filter.cve;
    $scope.items.author = $scope.filter.author;
    $scope.items.lang = $scope.filter.langid;
    $scope.items.group = $scope.filter.author;
    $scope.items.path = $scope.filter.author;
    $scope.items.lang_id = $scope.filter.lang_id;
    $scope.items.group_id = $scope.filter.group_id;
    $scope.selected_lang.lang_id = $scope.filter.lang_id;
    $scope.selected_lang.name = $scope.filter.lang_name;
    $scope.selected_lang.files = $scope.filter.lang_files;
    $scope.selected_group = $scope.filter.groups;
    
    $scope.vValues.v1 = $scope.filter.v1;
    $scope.vValues.v2 = $scope.filter.v2;
    $scope.vValues.v3 = $scope.filter.v3;
    $scope.vValues.t1 = $scope.filter.t1;
    $scope.vValues.t2 = $scope.filter.t2;
    $scope.vValues.t3 = $scope.filter.t3;
    $scope.vValues.f1 = $scope.filter.f1;
    $scope.vValues.f2 = $scope.filter.f2;
    $scope.vValues.f3 = $scope.filter.f3;
    
    $scope.editFilter = function (size,id) {
        $scope.items.nameOfPage = "Edit pattern #"+$scope.items.id;
        $scope.editF=true;
        
        var modalInstance = $modal.open({
        templateUrl: 'editFilter.html',
        controller: 'EditFilter',
        size: size,
        resolve: {
        items: function () {
            return $scope.items;
        },
        vValues: function () {
          return $scope.vValues;
        },
        tValues: function () {
          return $scope.tValues;
        },
        fValues: function () {
          return $scope.fValues;
        },
        jsonData: function () {
          return $scope.jsonData;
        },
        filter: function () {
          return $scope.filter;
        },
        languages: function () {
          return $scope.languages;
        },
        groups: function () {
          return $scope.groups;
        },
        selected_lang: function () {
          return $scope.selected_lang;
        },
        selected_group: function () {
          return $scope.selected_group;
        }
      }
    });
  };
    
    $scope.deleteFilter = function (size) {
        $scope.items.nameOfPage = "Remove pattern #"+$scope.items.id;
        var modalInstance = $modal.open({
            templateUrl: 'deleteUniversal.html',
            controller: 'DeleteFilter',
            size: size,
            resolve: {
            items: function () {
              return $scope.items;
            },
            vValues: function () {
              return $scope.vValues;
            },
            tValues: function () {
              return $scope.tValues;
            },
            fValues: function () {
              return $scope.fValues;
            }
          }
        });
    };
});
angular.module('ui.bootstrap.demo').controller('EditFilter', function ($scope, $modalInstance, items, vValues, tValues, fValues, languages, groups, selected_lang, selected_group){

    $scope.items = items;
    $scope.vValues = vValues;
    $scope.tValues = tValues;
    $scope.fValues = fValues;
    
    $scope.languages = languages;
    $scope.groups = groups;
    $scope.selected_lang = selected_lang;
    $scope.selected_group = selected_group;

  	$scope.ok = function () {
    
        if($scope.vValues.v1==""){
            alert("Requied V1 pattern!");
            return 0;
        }

         if($scope.items.name==""){
            alert("Please provide name!");
            return 0;
        }

        if($scope.items.lang==""){
            alert("Please provide lang!");
            return 0;
        }
	
        var data = "filtr_id="+encodeURIComponent($scope.items.id)+"&name="+encodeURIComponent($scope.items.name)+"&author="+encodeURIComponent($scope.items.author)+"&cwe="+encodeURIComponent($scope.items.cwe)+"&cve="+encodeURIComponent($scope.items.cve)+"&path="+encodeURIComponent($scope.items.path)+"&lang="+encodeURIComponent($scope.selected_lang.lang_id)+"&v1="+encodeURIComponent($scope.vValues.v1)+"&v2="+encodeURIComponent($scope.vValues.v2)+"&v3="+encodeURIComponent($scope.vValues.v3)+"&t1="+encodeURIComponent($scope.tValues.t1)+"&t2="+encodeURIComponent($scope.tValues.t2)+"&t3="+encodeURIComponent($scope.tValues.t3)+"&f1="+encodeURIComponent($scope.fValues.f1)+"&f2="+encodeURIComponent($scope.fValues.f2)+"&f3="+encodeURIComponent($scope.fValues.f3)+"";

        $.post('filters/update.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
            alert("Success. Note updated!");
            location.reload();            
        }).error(function(data, status, headers, config) {
            alert("Error. Not updated! Check error log ");
        });;
        
        $modalInstance.close();
    };

    $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
});
angular.module('ui.bootstrap.demo').controller('DeleteFilter', function ($scope, $modalInstance, items, vValues, tValues, fValues){

    $scope.items = items;
    
    $scope.ok = function () {
    
        if($scope.items.id==""){
            alert("Requied V1 pattern!");
            return 0;
        }

        var data = "filtr_id="+$scope.items.id+"&";

        $.post('filters/delete.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
                alert("Success. Filter deleted!");            
                location.reload();  
        }).error(function(data, status, headers, config) {
                alert("Error. Not updated! Check error log "+data); 
        });;
          
        $modalInstance.close();
    }
    
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});

<!------------ LANGUAGES PAGE CONTROLER ------------!>
angular.module('ui.bootstrap.demo').controller('languagesCtrl', function ($scope, $modal, $log, $filter){

    $scope.items = {'langId' : "", 'name' : "", 'description' : "", 'files' : "", 'nameOfPage' : 'cIFrex'};
    $scope.item_lang = {'langId' : "", 'name' : "", 'author' : "", 'files' : "", 'nameOfPage' : 'cIFrex'};
  
    $scope.editLang = function (size) {
        $scope.item_lang.lang_id = $scope.item.lang_id;
        $scope.item_lang.name = $scope.item.name;
        $scope.item_lang.description = $scope.item.description;
        $scope.item_lang.files = $scope.item.files
        $scope.item_lang.nameOfPage = "Edit pattern #"+$scope.item.lang_id;

        var modalInstance = $modal.open({
        templateUrl: 'saveLang.html',
        controller: 'EditLang',
        size: size,
        resolve: {
            items: function () {
                return $scope.items;
            },
            item_lang: function () {
                return $scope.item_lang;
            }

      }
    });
  };

    $scope.deleteLang = function (size) {
        $scope.item_lang.lang_id = $scope.item.lang_id;
        $scope.item_lang.name = $scope.item.name;
        $scope.items.name = $scope.item.name;
        
        $scope.items.nameOfPage = "Remove language #"+$scope.item.lang_id;
        var modalInstance = $modal.open({
            templateUrl: 'deleteUniversal.html',
            controller: 'DeleteLang',
            size: size,
            resolve: {
            items: function () {
              return $scope.items;
            },
            item_lang: function () {
              return $scope.item_lang;
            }
          }
        });
    };
});
angular.module('ui.bootstrap.demo').controller('EditLang', function ($scope, $modalInstance, items, item_lang){

    $scope.items = items;
    $scope.item_lang = item_lang;
    
  	$scope.ok = function () {
    	
        var data = "lang_id="+$scope.item_lang.lang_id+"&name="+encodeURIComponent($scope.item_lang.name)+"&description="+encodeURIComponent($scope.item_lang.description)+"&files="+encodeURIComponent($scope.item_lang.files)+"";
        $.post('languages/update.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
            alert("Success. Note updated!");
            location.reload();            
        }).error(function(data, status, headers, config) {
            alert("Error. Not updated! Check error log ");
        });;
        
        $modalInstance.close();
    };

    $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
});
angular.module('ui.bootstrap.demo').controller('DeleteLang', function ($scope, $modalInstance, items, item_lang){

    $scope.items = items;
    $scope.item_lang = item_lang;
    
    $scope.ok = function () {
    
        if($scope.item_lang.lang_id==""){
            alert("error id lang!");
            return 0;
        }

        var data = "lang_id="+encodeURIComponent($scope.item_lang.lang_id)+"&";

        $.post('languages/delete.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
                alert("Success. Language deleted!");            
                location.reload();  
        }).error(function(data, status, headers, config) {
                alert("Error. Not updated! Check error log "+data); 
        });;
          
        $modalInstance.close();
    }
    
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});


<!------------ GROUPS PAGE CONTROLER ------------!>
angular.module('ui.bootstrap.demo').controller('groupsCtrl', function ($scope, $modal, $log){

    $scope.items = {'group_id' : "", 'name' : "", 'description' : "", 'files' : ""};
    $scope.item_group = {'group_id' : "", 'name' : "", 'description' : "", 'path' : "", 'custom_files' : ""};

    $scope.items.name = $scope.group.name;    
    
    $scope.item_group.group_id = $scope.group.group_id;    
    $scope.item_group.name = $scope.group.name;    
    $scope.item_group.description = $scope.group.description;    
    $scope.item_group.path = $scope.group.path;
    $scope.item_group.custom_files = $scope.group.custom_files;    
    $scope.item_group.source = $scope.group.source;    
    
    $scope.items.nameOfPage = "Delete group #"+$scope.group.group_id;
    $scope.item_group.nameOfPage = "Edit group #"+$scope.group.group_id;

    $scope.editGroup = function (size) {

        var modalInstance = $modal.open({
        templateUrl: 'saveGroup.html',
        controller: 'EditGroup',
        size: size,
        resolve: {
        items: function () {
            return $scope.items;
        },   
        item_group: function () {
            return $scope.item_group;
        }
      }
    });
  };
    
    $scope.deleteGroup = function (size) {
        var modalInstance = $modal.open({
            templateUrl: 'deleteUniversal.html',
            controller: 'DeleteGroup',
            size: size,
            resolve: {
                items: function () {
                    return $scope.items;
                },   
                item_group: function () {
                    return $scope.item_group;
                }
          }
        });
    };
});
angular.module('ui.bootstrap.demo').controller('EditGroup', function ($scope, $modalInstance, items, item_group){

    $scope.items = items;
    $scope.item_group = item_group;
    
  	$scope.ok = function () {
        if($scope.item_group.name==""){
            alert("Empty name filed!");
            return 0;
        }
        
        if($scope.item_group.group_id==""){
            alert("Empty group_id filed!");
            return 0;
        }
        
        if($scope.item_group.description==""){
            alert("Empty desciption filed!");
            return 0;
        }
        
        if($scope.item_group.path==""){
            alert("Empty path filed!");
            return 0;
        }
        
        if($scope.item_group.custom_files==""){
            alert("Empty files filed!");
            return 0;
        }

        var data = "group_id="+$scope.item_group.group_id+"&name="+encodeURIComponent($scope.item_group.name)+"&description="+encodeURIComponent($scope.item_group.description)+"&path="+encodeURIComponent($scope.item_group.path)+"&custom_files="+encodeURIComponent($scope.item_group.name)+"&source="+encodeURIComponent($scope.item_group.source)+"";
        
        $.post('groups/update.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
            alert("Success. Group updated!");
            location.reload();            
        }).error(function(data, status, headers, config) {
            alert("Error. Not updated! Check error log ");
        });;
        
        $modalInstance.close();
    };

    $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
});
angular.module('ui.bootstrap.demo').controller('DeleteGroup', function ($scope, $modalInstance, items, item_group){

    $scope.item_group = item_group;
    $scope.items = items;
    
    $scope.ok = function () {
    
        if($scope.item_group.group_id==""){
            alert("error group_id");
            return 0;
        }

        var data = "group_id="+$scope.item_group.group_id+"&";
        
        $.post('groups/delete.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
                alert("Success. Filter deleted!");            
                location.reload();  
        }).error(function(data, status, headers, config) {
                alert("Error. Not updated! Check error log "+data); 
        });;
          
        $modalInstance.close();
    }
    
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});


<!------------ RESULT PAGE CONTROLER ------------!>                             
angular.module('ui.bootstrap.demo').controller('resultCtrl', function ($scope, $modal, $log, $filter){

    $scope.result = {'result_id' : ""};
    
    $scope.showFilter = function (size) {
        $scope.result.result_id = $scope.item.result_id;
        $scope.data = "";
        
        $.get('others/results-one.php?resId='+$scope.result.result_id).success(function(data) {
            
            $scope.resId = data;
            $scope.resId.debug_log=atob($scope.resId.debug_log);
            
            var modalInstance = $modal.open({
            templateUrl: 'resultFilter.html',
            controller: 'ResultFilter',
            size: size,
            resolve: {
                resId: function () {
                    return $scope.resId;
                }
            }
            });
        }).error(function(response) {
            alert("Ups! Error !");
            location.reload();
        });;
  };
    
  $scope.resultShow = function (size) {
        $scope.result.result_id = $scope.item.result_id;
        $scope.data = "";
        
        $.get('others/results-one.php?resId='+$scope.result.result_id).success(function(data) {
            
            $scope.resId = data;
            
            angular.forEach($scope.resId.result, function(value, key) {
                    value.array = atob(value.array);
            });
            
            var modalInstance = $modal.open({
            templateUrl: 'resultShow.html',
            controller: 'ShowResult',
            size: size,
            resolve: {
                resId: function () {
                    return $scope.resId;
                }
            }
            });
        }).error(function(response) {
            alert("Ups! Error !");
            location.reload();
        });;
  };
    
});
angular.module('ui.bootstrap.demo').controller('ResultFilter', function ($scope, $modalInstance, resId){

    $scope.resId = resId;

    $scope.delete = function () {
        $.get('others/results-delete.php?resId='+$scope.resId.result_id).success(function(data) {
            alert("Removed!");
            location.reload();            
        }).error(function(response) {
            alert("Ups! Error !");
            location.reload();
        });;  
    };
    
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
    
});
angular.module('ui.bootstrap.demo').controller('DeleteLang', function ($scope, $modalInstance, items, item_lang){

    $scope.items = items;
    $scope.item_lang = item_lang;
    
    $scope.ok = function () {
    
        if($scope.item_lang.lang_id==""){
            alert("error id lang!");
            return 0;
        }

        var data = "lang_id="+$scope.item_lang.lang_id+"&";

        $.post('languages/delete.php', data, function(data) {}, 'json').success(function(data, status, headers, config) {
                alert("Success. Language deleted!");            
                location.reload();  
        }).error(function(data, status, headers, config) {
                alert("Error. Not updated! Check error log "+data); 
        });;
          
        $modalInstance.close();
    }
    
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
angular.module('ui.bootstrap.demo').controller('ShowResult', function ($scope, $modalInstance, resId){

    $scope.resId = resId;
      
    $scope.delete = function () {
        $.get('others/results-delete.php?resId='+$scope.resId.result_id).success(function(data) {
            alert("Removed!");
            location.reload();            
        }).error(function(response) {
            alert("Ups! Error !");
            location.reload();
        });;  
    };
    
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    }; 
});
<!------------ FILTERS PAGE CONTROLER ------------!>
angular.module('ui.bootstrap.demo').controller('selectFiles', function ($scope, $modal, $log){
    $scope.setValue = function () {
        $scope.selected_lang.lang_id = $scope.lang_item.lang_id;
        $scope.selected_lang.name = $scope.lang_item.name;
        $scope.selected_lang.files = $scope.lang_item.files;
        $scope.selected_lang.description = $scope.lang_item.description;
    };
});
angular.module('ui.bootstrap.demo').controller('selectGroup', function ($scope, $modal, $log){
    $scope.setValue = function () {
        $scope.selected_group.group_id = $scope.group_item.group_id;
        $scope.selected_group.name = $scope.group_item.name;
        $scope.selected_group.description = $scope.group_item.description;
        $scope.selected_group.source = $scope.group_item.source;
        $scope.selected_group.path = $scope.group_item.path;
        $scope.selected_group.custom_files = $scope.group_item.custom_files;
        $scope.selected_group.created = $scope.group_item.created;
        $scope.selected_group.lastmod = $scope.group_item.lastmod;
        };
});
angular.module('ui.bootstrap.demo').controller('choseSaveToDb', function ($scope){
    $scope.selectSaveToDb = 'True';
    $scope.changeIt = function () {
              $scope.saveToDb=$scope.selectSaveToDb;
    };
});
