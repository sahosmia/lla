
import http from './http';

class RestApiManager {

    async getRecord(url, data = null){
        try {
            return await http.get(url, data);
        } catch(error){
            return {
                type        : 'error',
                status      : error.status,
                errorMsg    : error.statusText
            };
        }
    }

    async deleteRecord(url){
        try {
            return await http.delete(url);
        } catch(error){
            return {
                type        : 'error',
                status      : error?.response?.status,
                errorMsg    : error?.response?.statusText
            };
        }
    }

    async postRecord(url, data, contentType = 'application/json'){
        try {
            return await http.post(url, data, {
                headers: {
                    "Content-Type": contentType
                }
            });
        } catch(error){
            return error
        }
    }

    async sendMessage(url, data, contentType){
        try {
            return await http.post(url, data, {
                headers: {
                    "Content-Type": contentType
                }
            });
        } catch(error){
            return {
                type        : 'error',
                status      : error.status,
                errorMsg    : error.statusText
            };
        }
    }

    async updateRecord(url, data){
        try {
            return await http.put(url, data);
        } catch(error){
            console.error(error)
            return {
                type        : 'error',
                status      : error.status,
                errorMsg    : error.statusText
            };
        }
    }

    async updateFriendStatus(userId){
        try {
            return await http.post('friends', {userId});
        } catch(error) {
            return {
                type        : 'error',
                status      : error.status,
                errorMsg    : error.statusText
            };
        }
    }

    async getProfileInfo(){
        try {
            return await http.get('user');
        } catch(error) {
            return {
                type        : 'error',
                status      : error.status,
                errorMsg    : error.statusText
            };
        }
    }

    async updateProfileInfo(){
        try {
            return await http.get('user');
        } catch(error) {
            return {
                type        : 'error',
                status      : error.status,
                errorMsg    : error.statusText
            };
        }
    }

    async getunreadCounts(){
        try {
            return await http.get('unread-counts');
        } catch(error) {
            return {
                type        : 'error',
                status      : error.status,
                errorMsg    : error.statusText
            };
        }
    }
    
    async downloadAttachments(id){
        try {
            return await http.get(`download-all-attachments/${id}`, {responseType: 'blob'});
        } catch(error) {
            return {
                type: 'error',
                status: error.status,
                errorMsg: error.statusText
            };
        }
    }

}
export default new RestApiManager;