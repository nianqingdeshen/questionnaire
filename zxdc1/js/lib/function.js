/**
 * ===============================================
 * Created by ZHIHUA·WEI.
 * Author: ZHIHUA·WEI <zhihua_wei@foxmail.com>
 * Date: 2018/2/27
 * Time: 10:20
 * Project: 基于PHP和JS的AES相互加密解密方法详解(CryptoJS)
 * Power: Javascript common function
 * ===============================================
 */
 
/**
 * 接口数据加密函数
 * @param str string 需加密的json字符串
 * @param key string 加密key(16位)
 * @param iv string 加密向量(16位)
 * @return string 加密密文字符串
 */
function encrypt(str, key, iv) {
    //密钥16位
    var key = CryptoJS.enc.Utf8.parse(key);
    //加密向量16位
    var iv = CryptoJS.enc.Utf8.parse(iv);
    var encrypted = CryptoJS.AES.encrypt(str, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.ZeroPadding
    });
    return encrypted;
}
 
/**
 * 接口数据解密函数
 * @param str string 已加密密文
 * @param key string 加密key(16位)
 * @param iv string 加密向量(16位)
 * @returns {*|string} 解密之后的json字符串
 */
function decrypt(str, key, iv) {
    //密钥16位
    var key = CryptoJS.enc.Utf8.parse(key);
    //加密向量16位
    var iv = CryptoJS.enc.Utf8.parse(iv);
    var decrypted = CryptoJS.AES.decrypt(str, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.ZeroPadding
    });
    return decrypted.toString(CryptoJS.enc.Utf8);
}