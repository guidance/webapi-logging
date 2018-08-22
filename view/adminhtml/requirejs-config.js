/*
 *  @author     Guidance Magento Team <magento@guidance.com>
 *  @copyright  Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
var config = {
    map: {
        '*': {
            'jsonEditor': 'Guidance_WebapiLogging/js/jquery.json-editor',
            'jsonViewer': 'Guidance_WebapiLogging/js/jquery.json-viewer'
        }
    },
    shim: {
        'Guidance_WebapiLogging/js/jquery.json-editor': {
            deps: ['jsonViewer']
        },
        'Guidance_WebapiLogging/js/jquery.json-viewer': {
            deps: ['jquery']
        }
    }
};
