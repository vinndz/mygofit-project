package com.example.p3l.Fragment

import android.app.Activity
import android.content.Intent
import android.content.SharedPreferences
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import com.android.volley.AuthFailureError
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.p3l.Activity.BookingGymActivity
import com.example.p3l.Activity.HomeActivity
import com.example.p3l.Activity.LoginActivity
import com.example.p3l.Activity.PresensiInstrukturActivity
import com.example.p3l.Model.Auth
import com.example.p3l.Api.PegawaiApi
import com.example.p3l.Model.PresensiInstruktur
import com.example.p3l.databinding.FragmentManajerBinding
import com.google.gson.Gson
import com.shashank.sony.fancytoastlib.FancyToast
import org.json.JSONObject
import java.nio.charset.StandardCharsets

class ManajerFragment : Fragment() {
    private var _binding:FragmentManajerBinding? = null

    private val binding get() = _binding!!

    private var queue: RequestQueue? = null
    private lateinit var sharedPreferences: SharedPreferences

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        _binding = FragmentManajerBinding .inflate(inflater, container, false)
        val view = binding.root
        return view
    }


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

             sharedPreferences = (activity as HomeActivity).getSharedPreferences()
        queue = Volley.newRequestQueue(activity)

        binding.btnPresensi.setOnClickListener {
            val intent = Intent(activity, PresensiInstrukturActivity::class.java)
            startActivity(intent)
        }
    }


}