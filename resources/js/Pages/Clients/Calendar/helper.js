export const plainObjToProxyObj = (plainObj) => {
    if (plainObj === null) {
        return null;
    }
    const proxyObj = new Proxy(plainObj, {
        get: (target, prop) => {
            if (typeof target[prop] === 'object') {
                return plainObjToProxyObj(target[prop]);
            }

            return target[prop];
        },
        set: (target, prop, value) => {
            target[prop] = value;
            return true;
        },
    });

    return proxyObj;
};

export const proxyArrayToPlainArray = (proxyArray) => {
    const results = [];

    proxyArray.forEach((item) => {
        results.push(item);
    });

    return results;
};
