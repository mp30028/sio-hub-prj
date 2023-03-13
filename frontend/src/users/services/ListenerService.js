import * as ServicePaths  from "../../common/js/ServicePaths";

const INITIAL_WAIT_SECONDS = 1;
const MAX_WAIT_SECONDS = 128;
var retryAfter = INITIAL_WAIT_SECONDS;
var eventSource = null;
var messageHandler = null;	

export const setupEventSource = (onMessageHandler) => {
	messageHandler = onMessageHandler;
	
	const milliSecondsToWait = () => retryAfter * 1000;

	const tryToSetupEventSource = () => {
	    setupEventSource(messageHandler);
	    retryAfter = retryAfter * 2;
	    if (retryAfter >= MAX_WAIT_SECONDS) {
	        retryAfter = MAX_WAIT_SECONDS;
	    }
	};	
		
	const onerrorHandler = () =>{
		console.log("FROM ListenerService.onerrorHandler: An error was encountered. Resetting websocket connection and then retry");
		if (eventSource){
			eventSource.close();
			eventSource = null;	
		}		
		setTimeout(tryToSetupEventSource, milliSecondsToWait());
	};
	
	const onopenHandler = () =>{
		retryAfter = INITIAL_WAIT_SECONDS;
	};
	
	const oncloseHandler = () =>{
		console.log("FROM ListenerService.oncloseHandler: Websocket connection was closed. Will attemtp to reset and reconnect");
		if (eventSource){
			eventSource.close();
			eventSource = null;	
		}		
		setTimeout(tryToSetupEventSource, milliSecondsToWait());
	};
	
	if(!eventSource){
		eventSource = new WebSocket(ServicePaths.getEventsUrl());
		eventSource.onmessage = messageHandler;
		eventSource.onopen = onopenHandler;
		eventSource.onclose = oncloseHandler;
		eventSource.onerror = onerrorHandler;		
	}

};

