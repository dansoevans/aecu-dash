! function() {
    function e() {
        const e = function(e) {
                const t = e + "=",
                    n = document.cookie.split(";");
                for (let e = 0; e < n.length; e++) {
                    let o = n[e];
                    for (;
                        " " == o.charAt(0);) o = o.substring(1, o.length);
                    if (0 == o.indexOf(t)) return o.substring(t.length, o.length)
                }
                return null
            }("theme"),
            t = function(e) {
                let t;
                return location.search.substr(1).split("&").some((function(n) {
                    return n.split("=")[0] == e && (t = n.split("=")[1])
                })), t
            }("theme");
        return t ? (function(e, t, n) {
            let o = "";
            if (n) {
                const e = new Date;
                e.setTime(e.getTime() + 24 * n * 60 * 60 * 1e3), o = "; expires=" + e.toUTCString()
            }
            document.cookie = e + "=" + (t || "") + o + "; path=/"
        }("theme", t, 7), t) : e || "modern"
    }
    document.addEventListener("DOMContentLoaded", (() => {
        const t = document.createElement("link");
        t.href = "css/" + e() + ".css", t.type = "text/css", t.rel = "stylesheet", document.getElementsByTagName("head")[0].appendChild(t)
    }))
}();
//# sourceMappingURL=settings.js.map