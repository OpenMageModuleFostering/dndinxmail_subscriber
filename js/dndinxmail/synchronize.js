/**
 * @category            Module JS
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified        13/03/2013
 * @copyright            Copyright (c) 2012 Agence Dn'D
 * @author                Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

if(typeof DndInxmail == 'undefined') {
    var DndInxmail = {};
}

DndInxmail.Synchronize = Class.create();
DndInxmail.Synchronize.prototype = {

    passes: null,
    total: 0,
    totalGroups: 0,
    currentPass: 0,
    currentGroup: 0,
    listName: null,
    groups: null,
    storeId: null,
    startTime: null,
    scriptType: 'default',

    /*
     * Initialize Prototype Class
     */
    initialize: function() {
        this.passSubscribersAction = BASE_URL_STORE + 'dndinxmail_subscriber/synchronize/passSubscribers';
        this.passGroupsAction = BASE_URL_STORE + 'dndinxmail_subscriber/synchronize/passGroups';

        this.logStartAction = BASE_URL_STORE + 'dndinxmail_subscriber/log/start';
        this.logTryToCloseAction = BASE_URL_STORE + 'dndinxmail_subscriber/log/tryToClose';
        this.logEndAction = BASE_URL_STORE + 'dndinxmail_subscriber/log/end';


        this.initPreventScriptExit();
    },

    initPreventScriptExit: function() {

        var _self = this;

        window.onbeforeunload = function(e) {
            e = e || window.event;
            _self.tryToCloseLog();
            // For IE and Firefox prior to version 4
            if(e) {
                e.returnValue = 'Closing this page will stop the script. Are you sure you want to leave the page?';
            }
            // For Safari
            return 'Closing this page will stop the script. Are you sure you want to leave the page?';
        };

    },

    startLog: function(type) {
        this.scriptType = type;
        var passUrl = this.logStartAction + '/type/' + this.scriptType;
        new Ajax.Request(passUrl);
    },

    tryToCloseLog: function() {
        var passUrl = this.logTryToCloseAction + '/type/' + this.scriptType;
        new Ajax.Request(passUrl);
    },

    endLog: function() {
        var passUrl = this.logEndAction + '/type/' + this.scriptType;
        new Ajax.Request(passUrl);
    },

    launchSubscribers: function(request, store) {
        this.passes = request;
        this.total = request['total'];
        this.startTime = request['sync_start_time'];
        this.storeId = store;
        this.startLog('subscribers');
        this.synchronizePassSubscribers(request[0]);
    },

    synchronizePassSubscribers: function(pass) {
        if(typeof pass != 'undefined') {

            var current = Object.toJSON(pass);
            var passUrl = this.passSubscribersAction + '/store/' + this.storeId;
            var _self = this;
            var parameters = {pass: current};
            if (typeof _self.passes[_self.currentPass + 1] == 'undefined') {
                parameters['last_pass'] = true;
                parameters['sync_start_time'] = this.startTime;
            }
            new Ajax.Request(passUrl, {
                method: 'post',
                parameters: parameters,
                onLoading: function(transport) {
                    _self.outputSucces(_self.currentPass + 1, _self.total);
                },
                onSuccess: function(transport) {
                    if(transport.responseText) {
                        var result = transport.responseText;
                        var response = typeof JSON != 'undefined' ? JSON.parse(result) : eval('(' + result + ')');
                        if(response.failed != 'false') {
                            _self.outputError('Skip pass ' + (_self.currentPass + 1) + ' : ' + response.msg);
                        }

                        _self.currentPass++;

                        if(typeof _self.passes[_self.currentPass] != 'undefined') {
                            _self.synchronizePassSubscribers(_self.passes[_self.currentPass]);
                            return;
                        }

                        _self.outputSucces(0, 0, true);

                    }
                }
            });

        }
    },

    launchGroups: function(request) {
        this.passes = request;
        this.totalGroups = request['total'];
        this.startTime = request['sync_start_time'];
        this.startLog('groups');
        this.synchronizeGroups(this.passes[0]);
    },

    synchronizeGroups: function(group) {
        this.listName = group['name'];
        this.total = group['total'];
        delete group['name'];
        delete group['total'];
        this.outputGroup(this.listName);
        this.synchronizePassGroups(group[this.currentPass]);
    },

    synchronizePassGroups: function(pass) {

        if(typeof pass != 'undefined') {

            var current = Object.toJSON(pass);
            var passUrl = this.passGroupsAction;
            var _self = this;
            var firstPass = (this.currentPass == 0) ? 'true' : 'false';

            var parameters = {
                list: _self.listName,
                pass: current,
                first: firstPass
            };
            if (typeof _self.passes[_self.currentPass + 1] == 'undefined') {
                parameters['last_pass'] = true;
                parameters['sync_start_time'] = this.startTime;
            }

            new Ajax.Request(passUrl, {
                method: 'post',
                parameters: parameters,
                onLoading: function(transport) {
                    _self.outputSucces(_self.currentPass + 1, _self.total);
                },
                onSuccess: function(transport) {
                    if(transport.responseText) {
                        var result = transport.responseText;
                        var response = typeof JSON != 'undefined' ? JSON.parse(result) : eval('(' + result + ')');
                        if(response.failed != 'false') {
                            _self.outputError('Skip pass ' + (_self.currentPass + 1) + ' for "' + _self.listName + '" : ' + response.msg);
                        }

                        _self.currentPass++;

                        if(typeof _self.passes[_self.currentGroup][_self.currentPass] != 'undefined') {
                            _self.synchronizePassGroups(_self.passes[_self.currentGroup][_self.currentPass]);
                            return;
                        }

                        _self.currentGroup++

                        if(typeof _self.passes[_self.currentGroup] != 'undefined') {
                            _self.currentPass = 0;
                            _self.synchronizeGroups(_self.passes[_self.currentGroup]);
                            return;
                        }

                        _self.outputSucces(0, 0, true);

                    }
                }
            });

        }
    },

    outputError: function(error) {
        var parent = document.getElementById('errors');
        var list = document.createElement("li");
        list.innerHTML = error;
        parent.appendChild(list);
    },

    outputSucces: function(current, total, finish) {

        var list = document.getElementById('pass');
        var percentElement = document.getElementById('percent');

        if(typeof finish == 'undefined') {
            percent = Math.round(current * 100 / total);
            percentElement.innerHTML = percent + ' %';
            list.innerHTML = current + ' / ' + total + ' pass';
        }
        else {
            document.getElementById('loader-sync').style.display = 'none';
            percentElement.innerHTML = '100 %';
            list.innerHTML = 'Finish';
            window.onbeforeunload = null;
            this.endLog();
        }

    },

    outputGroup: function(name) {
        var spanElement = document.getElementById('current-group');
        var percent = Math.round((this.currentGroup + 1) * 100 / this.totalGroups);
        spanElement.innerHTML = 'Group ' + (this.currentGroup + 1) + ' / ' + this.totalGroups + ' (' + percent + ' %) : ' + name;
    }

}