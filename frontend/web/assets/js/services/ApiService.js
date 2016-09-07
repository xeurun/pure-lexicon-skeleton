(function() {
    "use strict";

    function ApiService($rootScope, $http, $q) {
        var callWithCustomCallback = function(request, callbacks) {
            var deferred = $q.defer();

            request
                .success((!angular.isUndefined(callbacks) &&
                    angular.isFunction(callbacks['success'])) ?
                        callbacks['success'] :
                        function(response, status, headers, config) {
                            if (!response.error && response.message) {
                                $rootScope.$broadcast('popup:show', {type: 'success', message: response.message});
                            }else if(response.error) {
                                $rootScope.$broadcast('popup:show', {type: 'danger', message: response.error});
                            }

                            deferred.resolve(response);
                        }
                )
                .error((!angular.isUndefined(callbacks) &&
                    angular.isFunction(callbacks['error'])) ?
                        callbacks['error'] :
                        function(response, status, headers, config) {
                            $rootScope.$broadcast('popup:show', {type: 'danger', message: 'ERROR!'});

                            deferred.reject(response);
                        }
                );

            return deferred.promise;
        };

        this.jsonp = function(url, data, callbacks) {
            return callWithCustomCallback($http.jsonp(url, {
                params: data
            }), callbacks);
        };

        this.get = function(url, data, callbacks) {
            return callWithCustomCallback($http.get(url, {
                params: data
            }), callbacks);
        };

        this.delete = function(url, data, callbacks) {
            return callWithCustomCallback($http.delete(url, data), callbacks);
        };

        this.post = function(url, data, callbacks) {
            return callWithCustomCallback($http.post(url, data), callbacks);
        };

        this.put = function(url, data, callbacks) {
            return callWithCustomCallback($http.put(url, data), callbacks);
        };
    }

    angular.module('pure-lexicon').service('ApiService', ApiService);
})();