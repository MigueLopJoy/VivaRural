const fetchHandler = async (url, fetchData = null) => {
    try {
        let res = await fetch(url, fetchData),
            json = await res.json()
        if (!res.ok) throw { status: res.status, statusText: res.statusText }
        return json
    } catch (error) {
        throw error
    }
}

const getRequestData = (method, body) => {
    return {
        method,
        body
    }
}

export {
    fetchHandler,
    getRequestData
}