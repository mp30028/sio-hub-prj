
export const doCreate = (currentData, eventData) =>{
	const results = [...currentData];
	eventData.forEach((newDataItem) =>{
		results.push(newDataItem);
	});
	return results;
}

export const doDelete = (currentData, eventData) =>  {	
	var results = currentData.filter( (sourceDataItem) => {		
        var internalResult = eventData.filter( (newDataItem) => {
            return (sourceDataItem.id !== newDataItem.id);
        });
		return internalResult[0];
	});
    return results;
};

export const doUpdate = (currentData, eventData) =>  {
	var results = currentData.map( (sourceDataItem) => {
        var internalResult = eventData.map( (newDataItem) => {
            if (sourceDataItem.id === newDataItem.id){
				return newDataItem;
            }else{
				return sourceDataItem;
            }
        });
		return internalResult[0];
	});
    return results;
};