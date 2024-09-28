class Cookie{

    static getCookies = () =>{
        let cookies = {};
        document.cookie.split(";").forEach(elt => {
            let keyVal = elt.split("=");
            if (keyVal.length == 2){
                cookies[decodeURI(keyVal[0].trim())] = decodeURI(keyVal[1].trim());
            }
        });
        return cookies;
    }

    static getCookie = (key) =>{
        return this.getCookies()[key];
    }

    static setCookie = (key, value) =>{
        document.cookie = `${key}=${value};`
    }
}


export default Cookie;