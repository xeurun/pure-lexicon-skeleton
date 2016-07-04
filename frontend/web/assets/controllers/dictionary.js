angular.module('pure-lexicon-skeleton')
    .controller('DictionaryController', function ($scope, $log, $sce) {
        var self = this;
        self.simulateQuery = false;
        self.isDisabled = false;
        self.phrases = loadPhrases();
        self.alternatives = [];
        self.descriptions = [];
        self.querySearch = querySearch;
        self.selectPhrase = selectPhrase;
        self.searchTextChange = searchTextChange;
        self.incrementRating = incrementRating;
        self.decrementRating = decrementRating;

        self.selectedPhrase = null;

        // ******************************
        // Internal methods
        // ******************************

        /**
         * Search for phrases... use $timeout to simulate
         * remote dataservice call.
         */
        function querySearch(query) {
            var results = query ? self.phrases.filter(createFilterFor(query)) : self.phrases,
                deferred;
            if (self.simulateQuery) {
                deferred = $q.defer();
                $timeout(function () { deferred.resolve(results); }, Math.random() * 1000, false);
                return deferred.promise;
            } else {
                return results;
            }
        }

        function searchTextChange(text) {
            $log.info('Text changed to ' + text);
        }

        function selectPhrase(item) {
            $log.info('Item changed to ' + JSON.stringify(item));
            this.selectedPhrase = item;
            this.alternatives = loadAlternatives(Number(item.id));
            this.descriptions = loadDescriptions(Number(item.id));
        }

        /**
         * Build `components` list of key/value pairs
         */
        function loadPhrases() {
            var phrases = [
                {
                    'id': 253,
                    'text': 'слава богу',
                    'altcount': 1,
                    'rating': 870
                },
                {
                    'id': 124,
                    'text': 'спасибо',
                    'altcount': 4,
                    'rating': 352
                },
                {
                    'id': 567,
                    'text': 'благодарю',
                    'altcount': 0,
                    'rating': -14
                },
            ];

            return phrases.map(function (x) {
                x.value = x.text.toLowerCase();
                return x;
            });
        }

        function loadAlternatives(phraseId) {
            var alts = [];
            switch (phraseId) {
                case 124:
                    alts = [
                        {
                            'id': 2362,
                            'text': 'благодарю',
                            'rating': 153,
                        },
                        {
                            'id': 6347,
                            'text': 'я ваш должник',
                            'rating': 50,
                        },
                        {
                            'id': 2568,
                            'text': 'вы очень добры',
                            'rating': 33,
                        },
                        {
                            'id': 578,
                            'text': 'дякую',
                            'rating': 19,
                        },
                    ];
                    break;
                case 567:
                    alts = [

                    ];
                    break;
                case 253:
                    alts = [
                        {
                            'id': 34587,
                            'text': 'какая удача',
                            'rating': 45,
                        },
                    ];
                    break;
                default:
                    break;
            }
            return alts.map(function (x) {
                x.value = x.text.toLowerCase();
                return x;
            });
        }

        function loadDescriptions(phraseId) {
            var descs = [];
            switch (phraseId) {
                case 124:
                    descs = [
                        {
                            'id': 789876,
                            'text': 'Спасибо — вежливое слово, которое говорят, чтобы выразить благодарность. Но «Спасибо» имеет более глубокий смысл. Если, например, английское «thank you» - «голое» выражение благодарности, то в исконно русском слове «спасибо» сокрыт гораздо более глубокий смысл, чем может казаться на первый взгляд. «Спасибо» появилось в XVI веке как пожелание, чтобы Бог спас человека за добрый поступок или дела: «Спаси Бог!». Позже произошло сращение двух слов с отпадением после утраты редуцированного конечного «г».  Кстати, ежегодно 11 января отмечается даже Всемирный день «спасибо».',
                            'rating': 50,
                        },
                    ];
                    break;
                case 567:
                    descs = [
                        {
                            'id': 235425,
                            'text': 'Слово БЛАГОДАРЮ образовано из двух слов БЛАГО и ДАРИТЬ-ДАРЮ. Произнося данное слово, вы делитесь частью вашего БЛАГА и лично вы сами, а ни кто-то другой отвечаете добром на добро.',
                            'rating': 31,
                        },
                        {
                            'id': 2547786,
                            'text': 'Слово БЛАГО ошибочно наделять сокральным смыслом, это просто древнерусский синоним слова ДОБРО. Тут интересная <a href="http://allpravda.info/content/653.html">статья</a>, и <a href="http://fizrazvitie.ru/2011/02/spasibo-blagodaru.html">ещё</a>',
                            'rating': 10,
                        },                        
                    ];
                    break;
                case 253:
                    descs = [
                       
                    ];
                    break;
                default:
                    break;
            }
            return descs.map(function (x) {
                x.value = x.text.toLowerCase();
                x.text = $sce.trustAsHtml(x.text);
                return x;
            });
        }

        /**
         * Create filter function for a query string
         */
        function createFilterFor(query) {
            var lowercaseQuery = angular.lowercase(query);
            return function filterFn(item) {
                return (item.value.indexOf(lowercaseQuery) === 0);
            };
        }

        function incrementRating($event, item) {
            item.rating++;
            $event.stopPropagation();
        }

        function decrementRating($event, item) {
            item.rating--;
            $event.stopPropagation();
        }
    });