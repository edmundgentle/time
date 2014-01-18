(function ( $ ) {
	$.time = function( options ) {
		if(options.forgetme===undefined) {
			var settings = $.extend( {
				langFile:'../src/langs/en.json',
				cache:{},
				forgetme:true,
				refreshRate:60000
			}, options);
			$.ajax({
				dataType: "json",
				url: settings.langFile,
				success: function(data) {
					settings.cache=data;
					$.time(settings);
				}
			});
		}else{
			settings=options;
			
			var now=(new Date().getTime())/1000;
			var nw=new Date();
			var yd=new Date(((now-86400)*1000));
			$('.jq_time_live').each(function(index) {
				var t=$(this);
				
				var timestamp=$(this).attr('data-time');
				var ts=new Date(timestamp*1000);
				var relative_time=$.time_parse_string(settings.cache.format,ts,settings.cache);
				var diff=now-timestamp;
				
				if(diff<60) {
					relative_time=settings.cache.relative[0];
				}else if(diff<3600) {
					if(Math.floor(diff/60)==1) {
						relative_time=settings.cache.relative[1];
					}else{
						relative_time=settings.cache.relative[2];
						relative_time=relative_time.replace('[MIN]',Math.floor(diff/60));
					}
				}else if(diff<86400) {
					if(Math.floor(diff/3600)==1) {
						relative_time= settings.cache.relative[3];
					}else{
						if((ts.getDate()+'/'+ts.getMonth()+'/'+ts.getFullYear())!=(nw.getDate()+'/'+nw.getMonth()+'/'+nw.getFullYear())) {
							relative_time=$.time_parse_string(settings.cache.relative[4],ts,settings.cache);
						}else{
							relative_time=settings.cache.relative[5];
							relative_time=relative_time.replace('[HOUR]',Math.floor(diff/3600));
						}
					}
				}else if(diff<604800) {
					if((ts.getDate()+'/'+ts.getMonth()+'/'+ts.getFullYear())==(yd.getDate()+'/'+yd.getMonth()+'/'+yd.getFullYear())) {
						relative_time=$.time_parse_string(settings.cache.relative[4],ts,settings.cache);
					}else{
						relative_time=$.time_parse_string(settings.cache.relative[6],ts,settings.cache);
					}
				}else{
					if(ts.getFullYear()!=nw.getFullYear()) {
						relative_time=$.time_parse_string(settings.cache.relative[7],ts,settings.cache);
					}else{
						relative_time=$.time_parse_string(settings.cache.relative[8],ts,settings.cache);
					}
				}

				t.html(relative_time);
			});
			if(settings.refreshRate>0) {
				setTimeout(function(){$.time(settings);},settings.refreshRate);
			}
		}
		return true;
	};
	$.time_parse_string=function(time_string,timestamp,cache) {
		if(cache) {
			var ap='am';
			var hr=timestamp.getHours();
			if(hr>12) {
				ap='pm';
				hr-=12;
			}
			time_string=time_string.replace('[DAY]',cache['day'][timestamp.getDay()]);
			time_string=time_string.replace('[FDAY]',cache['fullday'][timestamp.getDay()]);
			time_string=time_string.replace('[DATE]',timestamp.getDate());
			time_string=time_string.replace('[MONTH]',cache['month'][timestamp.getMonth()]);
			time_string=time_string.replace('[FMONTH]',cache['fullmonth'][timestamp.getMonth()]);
			time_string=time_string.replace('[YEAR]',(""+timestamp.getFullYear()).substring(2));
			time_string=time_string.replace('[FYEAR]',timestamp.getFullYear());
			time_string=time_string.replace('[HOUR]',hr);
			time_string=time_string.replace('[FHOUR]',("0" + timestamp.getHours()).slice(-2));
			time_string=time_string.replace('[MIN]',("0" + timestamp.getMinutes()).slice(-2));
			time_string=time_string.replace('[AMPM]',cache[ap]);
			return time_string;
		}
	}
}( jQuery ));