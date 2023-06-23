package com.example.p3l.Fragment

import android.app.Activity
import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.EditText
import android.widget.TextView
import com.android.volley.AuthFailureError
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.p3l.Activity.*
import com.example.p3l.Api.PegawaiApi
import com.example.p3l.Api.ProfileApi
import com.example.p3l.Model.Auth
import com.example.p3l.Model.Member
import com.example.p3l.R
import com.example.p3l.databinding.FragmentMemberBinding
import com.example.p3l.databinding.FragmentProfileMemberBinding
import com.google.gson.Gson
import com.shashank.sony.fancytoastlib.FancyToast
import org.json.JSONObject
import java.nio.charset.StandardCharsets



class ProfileMemberFragment : Fragment() {


    private var _binding: FragmentProfileMemberBinding? = null

    private val binding get() = _binding!!

    private var queue: RequestQueue? = null
    private lateinit var sharedPreferences: SharedPreferences


    private lateinit var editTextName: EditText
    private lateinit var editTextPassword: EditText


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        _binding = FragmentProfileMemberBinding.inflate(inflater, container, false)
        val view = binding.root
        return view
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {

        super.onViewCreated(view, savedInstanceState)

        sharedPreferences = (activity as HomeActivity).getSharedPreferences()
        val id = sharedPreferences.getString("id", null)
        queue = Volley.newRequestQueue(activity)
        getProfileById(id)

        binding.btnLogout.setOnClickListener {
            logout()
        }

        binding.btnHistory.setOnClickListener{
            val intent = Intent(activity, HistoryAktivitasMemberActivity::class.java)
            startActivity(intent)
        }

    }

    private fun getProfileById(id: String?){

        val stringRequest: StringRequest = object :
            StringRequest(
                Method.GET, ProfileApi.GETDATAMEMBER + id,
                { response ->

                    var jo = JSONObject(response.toString())
                    var member = arrayListOf<Member>()
                    var id : Int = jo.getJSONArray("data").length()

                    for(i in 0 until id) {
                        var data = Member(
                            jo.getJSONArray("data").getJSONObject(i).getString("ID_MEMBER"),
                            jo.getJSONArray("data").getJSONObject(i).getString("NAMA_MEMBER"),
                            jo.getJSONArray("data").getJSONObject(i).getString("EMAIL_MEMBER"),
                            jo.getJSONArray("data").getJSONObject(i).getString("MASA_AKTIVASI"),
                            jo.getJSONArray("data").getJSONObject(i).getDouble("SISA_DEPOSIT_MEMBER"),
                            jo.getJSONArray("data").getJSONObject(i).getString("SISA_DEPO")
                        )
                        member.add(data)
                    }
                    binding.tvnama.setText(jo.getJSONArray("data").getJSONObject(0).getString("NAMA_MEMBER"))
                    binding.tvemail.setText(jo.getJSONArray("data").getJSONObject(0).getString("EMAIL_MEMBER"))
                    if(jo.getJSONArray("data").getJSONObject(0).getString("MASA_AKTIVASI") == "null"){
                        binding.tvmasaberlaku.setText("Belum Aktivasi")
                    }else{
                        binding.tvmasaberlaku.setText(jo.getJSONArray("data").getJSONObject(0).getString("MASA_AKTIVASI"))
                    }

                    binding.tvsisadeposituang.setText("Rp."+jo.getJSONArray("data").getJSONObject(0).getDouble( "SISA_DEPOSIT_MEMBER").toString())
                    binding.tvsisadepositkelas.setText(""+jo.getJSONArray("data").getJSONObject(0).getString("SISA_DEPO").toString())


                    FancyToast.makeText(requireActivity(),"Data Profile Berhasil ditampilkan", FancyToast.LENGTH_SHORT, FancyToast.SUCCESS, false).show()
                },
                Response.ErrorListener{ error ->
                    try{
                        val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
                        val errors = JSONObject(responseBody)
                        FancyToast.makeText(
                            requireActivity(),
                            errors.getString("message"),
                            FancyToast.LENGTH_SHORT, FancyToast.INFO, false
                        ).show()
                    } catch (e: Exception){
                        FancyToast.makeText(requireActivity(), e.message, FancyToast.LENGTH_SHORT, FancyToast.ERROR, false).show()
                    }
                }) {
            @Throws(AuthFailureError::class)
            override fun getHeaders(): Map<String, String> {
                val headers = java.util.HashMap<String, String>()
                headers["Authorization"] = "Bearer " + sharedPreferences.getString("token",null);
                headers["Accept"] = "application/json"
                return headers
            }
        }
        queue!!.add(stringRequest)

    }





    private fun logout(){
        val auth = Auth(
            "",
            "")

        val stringRequest: StringRequest =
            object : StringRequest(Request.Method.POST, PegawaiApi.LOGOUT_URL, Response.Listener { response ->
                val gson = Gson()
                var user_logout = gson.fromJson(response, Auth::class.java)


                if(user_logout != null) {

                    val intent = Intent(activity, LoginActivity::class.java)
                    sharedPreferences.edit()
                        .putInt("id",-1)
                        .putString("id", null)
                        .putString("role",null)
                        .putString("token",null)
                        .apply()
                    FancyToast.makeText(context as Activity,"Berhasil Logout",
                        FancyToast.LENGTH_LONG,
                        FancyToast.SUCCESS,false).show()
                    startActivity(intent)
                }
                else {
                    FancyToast.makeText(context as Activity,"Gagal Logout",
                        FancyToast.LENGTH_LONG,
                        FancyToast.SUCCESS,false).show()
                }
                return@Listener
            }, Response.ErrorListener { error ->
                try {
                    val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
                    val errors = JSONObject(responseBody)
                    FancyToast.makeText(context as Activity, errors.getString("message"), FancyToast.LENGTH_LONG, FancyToast.INFO, false).show()
                }catch (e: Exception) {
                    FancyToast.makeText(context as Activity, e.message, FancyToast.LENGTH_LONG, FancyToast.ERROR, false).show()
                }
            }) {
                @Throws(AuthFailureError::class)
                override fun getHeaders(): Map<String, String> {
                    val headers = HashMap<String, String>()
                    headers["Accept"] = "application/json"
                    headers["Authorization"] = "Bearer " + sharedPreferences.getString("token",null);
                    return headers
                }

                @Throws(AuthFailureError::class)
                override fun getBody(): ByteArray {
                    val gson = Gson()
                    val requestBody = gson.toJson(auth)
                    return requestBody.toByteArray(StandardCharsets.UTF_8)
                }

                override fun getBodyContentType(): String {
                    return "application/json; charset=utf-8;"
                }
            }
        queue!!.add(stringRequest)

    }


}