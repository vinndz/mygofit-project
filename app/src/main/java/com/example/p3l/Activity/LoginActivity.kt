package com.example.p3l.Activity


import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.EditText
import android.widget.LinearLayout
import android.widget.Toast
import androidx.constraintlayout.widget.ConstraintLayout
import com.android.volley.AuthFailureError
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.p3l.Model.Auth
import com.example.p3l.Api.PegawaiApi
import com.example.p3l.R
import com.example.p3l.SplashScreen
import com.example.p3l.databinding.ActivityLoginBinding
import com.google.android.material.textfield.TextInputLayout
import com.google.gson.Gson
import com.shashank.sony.fancytoastlib.FancyToast
import org.json.JSONObject
import java.nio.charset.StandardCharsets


class LoginActivity : AppCompatActivity() {
    private lateinit var binding: ActivityLoginBinding

    private lateinit var inputUsername: TextInputLayout
    private lateinit var inputPassword: TextInputLayout
    var editTextName: EditText? = null
    var editTextPassword: EditText? = null
    private lateinit var mainLayout: ConstraintLayout

    private var queue: RequestQueue? = null

    private val myPreference = "myPref"
    private val et_email = "Email"
    private val et_password = "password"
    var sharedPreferences: SharedPreferences? = null
    var sharedPreferences2: SharedPreferences? = null
    private var layoutLoading: LinearLayout? = null

    var email: String = ""
    var inputanPassword: String = ""
//    val auth = Auth(email, password)

    override fun onCreate(savedInstanceState: Bundle?) {
        val isFirstRun = getSharedPreferences("login", MODE_PRIVATE).getBoolean("isFirstRun",true)

        if(isFirstRun){
            startActivity(Intent(this@LoginActivity, SplashScreen :: class.java))
            finish()
        }
        getSharedPreferences("login", MODE_PRIVATE).edit().putBoolean("isFirstRun",false).commit()

        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        sharedPreferences = getSharedPreferences("login", Context.MODE_PRIVATE)
//        sharedPreferences2 = getSharedPreferences("login", Context.MODE_PRIVATE)

        queue = Volley.newRequestQueue(this)
        inputUsername = binding.inputLayoutUsername
        inputPassword = binding.inputLayoutPassword
        editTextPassword = binding.etPassword
        editTextName = binding.etUsername
        mainLayout = binding.mainLayout
        layoutLoading = findViewById(R.id.layout_loading)

        if (sharedPreferences!!.contains(et_email)) {
            editTextName?.setText(sharedPreferences!!.getString(et_email, ""))
        }
        if (sharedPreferences!!.contains(et_password)) {
            editTextPassword?.setText(sharedPreferences!!.getString(et_password, ""))
        }

        val btnLogin = binding.btnLogin
        val btnGantipw = binding.btnGantipw
        val btnInformasi = binding.btnInformasi

        btnGantipw.setOnClickListener {
           val intent = Intent(this, ForgetPasswordActivity::class.java)
            startActivity(intent)
        }

        btnLogin.setOnClickListener OnClickListener@{

            cekLogin()
        }

        btnInformasi.setOnClickListener {
            val intent = Intent(this, UmumActivity::class.java)
            startActivity(intent)
        }

    }

    private fun cekLogin() {
        // Fungsi untuk menampilkan data user berdasarkan id

        val username: String = inputUsername.getEditText()?.getText().toString()
        val password: String = inputPassword.getEditText()?.getText().toString()

        if (inputUsername.getEditText()?.getText().toString().isEmpty()) {
            Toast.makeText(this@LoginActivity, "Username tidak boleh kosong!", Toast.LENGTH_SHORT)
                .show()
        } else if (inputPassword.getEditText()?.getText().toString().isEmpty()) {
            Toast.makeText(this@LoginActivity, "Password tidak boleh kosong!", Toast.LENGTH_SHORT)
                .show()
        } else {

            email = binding.inputLayoutUsername.editText?.text.toString()
            inputanPassword = binding.inputLayoutPassword.editText?.text.toString()

            binding.inputLayoutUsername.setError(null)
            binding.inputLayoutPassword.setError(null)

            val auth = Auth(email, inputanPassword)

            val stringRequest: StringRequest =
                object : StringRequest(
                    Request.Method.POST,
                    PegawaiApi.LOGIN_URL,
                    Response.Listener { response ->
                        val gson = Gson()

                        var jsonObj = JSONObject(response.toString())
                        var userObjectData = jsonObj.getJSONObject("user")

                        if (userObjectData.has("ID_MEMBER")) {
                            val token = jsonObj.getString("access_token")
                            val move = Intent(this@LoginActivity, HomeActivity::class.java)
                            FancyToast.makeText(
                                this,
                                "Data berhasil ditemukan",
                                FancyToast.LENGTH_LONG,
                                FancyToast.SUCCESS,
                                false
                            ).show()
                            sharedPreferences!!.edit()
                                .putString("id", userObjectData.getString("ID_MEMBER"))
                                .putString("role", "member")
                                .putString("token", token)
                                .apply()

                            startActivity(move)
                        } else if (userObjectData.has("ID_PEGAWAI")) {
                            val token = jsonObj.getString("access_token")
                            sharedPreferences!!.edit()
                                .putInt("id", userObjectData.getInt("ID_PEGAWAI"))
                                .putString("role", "manager operational")
                                .putString("token", token)
                                .apply()
                            FancyToast.makeText(
                                this,
                                "",
                                FancyToast.LENGTH_LONG,
                                FancyToast.SUCCESS,
                                false
                            ).show()

                            val move = Intent(this@LoginActivity, HomeActivity::class.java)
                            startActivity(move)
                        } else if (userObjectData.has("ID_INSTRUKTUR")) {
                            val token = jsonObj.getString("access_token")
                            sharedPreferences!!.edit()
                                .putInt("id", userObjectData.getInt("ID_INSTRUKTUR"))
                                .putString("role", "instruktur")
                                .putString("token", token)
                                .apply()
                            FancyToast.makeText(
                                this,
                                "Data berhasil ditemukan",
                                FancyToast.LENGTH_LONG,
                                FancyToast.SUCCESS,
                                false
                            ).show()
                            val move = Intent(this@LoginActivity, HomeActivity::class.java)
                            startActivity(move)
                        }
                    },
                    Response.ErrorListener { error ->
                        try {
                            val responseBody =
                                String(error.networkResponse.data, StandardCharsets.UTF_8)
                            val errors = JSONObject(responseBody)
                            Toast.makeText(
                                this@LoginActivity,
                                errors.getString("message"),
                                Toast.LENGTH_SHORT
                            ).show()
                        } catch (e: Exception) {
                            Toast.makeText(this@LoginActivity, e.message, Toast.LENGTH_SHORT).show()
                        }
                    }) {
                    @kotlin.jvm.Throws(AuthFailureError::class)
                    override fun getHeaders(): Map<String, String> {
                        val headers = HashMap<String, String>()
                        headers["Accept"] = "application/json"
//                        headers["Authorization"] = "Bearer " + sharedPreferences!!.getString("token",null);
                        return headers
                    }

                    @Throws(AuthFailureError::class)
                    override fun getBody(): ByteArray {
                        val gson = Gson()
                        val requestBody = gson.toJson(auth)
                        return requestBody.toByteArray(StandardCharsets.UTF_8)
                    }

                    override fun getBodyContentType(): String {
                        return "application/json"
                    }
                }
            queue!!.add(stringRequest)
        }
    }
}

