import axios from "axios";

let profile = {};

async function getProfile() {
    const respone = await axios.get('/api/profile_setting/1');
    return respone.data.result;
}
profile = getProfile();

export default profile;