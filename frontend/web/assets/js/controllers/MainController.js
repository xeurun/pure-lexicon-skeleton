(function() {
    "use strict";

    function MainController($log, $mdDialog, ApiService) {
        var self = this;
        self.simulateQuery = false;
        self.isDisabled = false;
        self.phrases = [];
        self.newWord = {};
        self.selectedPhrase = null;

        self.cancel = function() {
            self.selectedPhrase = null;
            $mdDialog.cancel();
        };

        self.save = function() {
            ApiService.post('api/v1/frontend/json/word?expand=alternatives', self.newWord).then(function(data) {
                var isNew = true;
                angular.forEach(self.phrases, function(phrase, id) {
                    if (phrase.id === data.id) {
                        isNew = false;
                        self.phrases[id] = data;
                    }
                });

                if (isNew) {
                    self.phrases.push(data);
                }
            });
            $mdDialog.hide();
        };

        self.showAddForm = function($event) {
            $mdDialog.show({
                targetEvent: $event,
                contentElement: '#addForm',
                parent: angular.element(document.body),
                clickOutsideToClose: true
            });
        };

        self.showShowForm = function($event, item) {
            self.selectedPhrase = item;

            $mdDialog.show({
                targetEvent: $event,
                contentElement: '#showForm',
                parent: angular.element(document.body),
                clickOutsideToClose: true
            });
        };

        /**
         * Build `components` list of key/value pairs
         */
        self.loadPhrases = function () {
            ApiService.get('api/v1/frontend/json/word?expand=alternatives').then(function(data) {
                self.phrases = data;
            });
        };

        // ******************************
        // Internal methods
        // ******************************

        /**
         * Search for phrases... use $timeout to simulate
         * remote dataservice call.
         */
        self.querySearch = function (query) {
            var results = query ? self.phrases.filter(createFilterFor(query)) : self.phrases,
                deferred;

            if (self.simulateQuery) {
                deferred = $q.defer();
                $timeout(function () { deferred.resolve(results); }, Math.random() * 1000, false);
                return deferred.promise;
            } else {
                return results;
            }
        };

        self.searchTextChange = function (text) {
            $log.info('Text changed to ' + text);
        };

        /**
         * Create filter function for a query string
         */
        function createFilterFor(query) {
            var lowercaseQuery = angular.lowercase(query);
            return function filterFn(item) {
                return (item.title.indexOf(lowercaseQuery) === 0);
            };
        }

        self.incrementRating = function ($event, item) {
            $event.stopPropagation();

            item.rating++;
            ApiService.put('api/v1/frontend/json/word/' + item.id, {'rating': item.rating});
        };

        self.decrementRating = function($event, item) {
            $event.stopPropagation();

            item.rating--;
            ApiService.put('api/v1/frontend/json/word/' + item.id, {'rating': item.rating});
        };
    }

    angular.module('pure-lexicon').controller('MainController', MainController);
})();