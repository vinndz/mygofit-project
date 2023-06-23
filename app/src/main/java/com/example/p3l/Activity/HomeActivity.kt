package com.example.p3l.Activity

import android.content.Context
import android.content.DialogInterface
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.Menu
import android.view.MenuInflater
import android.view.MenuItem
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.Fragment
import com.example.p3l.Fragment.*
import com.example.p3l.R
import com.example.p3l.databinding.ActivityHomeBinding


class HomeActivity : AppCompatActivity() {

    private lateinit var binding: ActivityHomeBinding
    private lateinit var sharedPreferences: SharedPreferences


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityHomeBinding.inflate(layoutInflater)
        setContentView(binding.root)

        sharedPreferences = getSharedPreferences("login", Context.MODE_PRIVATE)
        val role = sharedPreferences.getString("role", null)

        Toast.makeText(this@HomeActivity, role.toString(), Toast.LENGTH_SHORT).show()

        if (role == "member") {
            setCurrentFragment(MemberFragment())
            binding.bottomNavigation.setOnItemSelectedListener { itemId ->
                when (itemId) {
                    R.id.ic_home -> setCurrentFragment(MemberFragment())
                    R.id.ic_profile -> setCurrentFragment(ProfileMemberFragment())
                }
                true
            }
        }


        if (role == "manager operational") {
            setCurrentFragment(ManajerFragment())
            binding.bottomNavigation.setOnItemSelectedListener { itemId ->
                when (itemId) {
                    R.id.ic_home -> setCurrentFragment(ManajerFragment())
                    R.id.ic_profile -> setCurrentFragment(ProfileManajerFragment())
                }
                true
            }
        }

        if (role == "instruktur") {
            setCurrentFragment(InstrukturFragment())
            binding.bottomNavigation.setOnItemSelectedListener { itemId ->
                when (itemId) {
                    R.id.ic_home -> setCurrentFragment(InstrukturFragment())
                    R.id.ic_profile -> setCurrentFragment(ProfileInstrukturFragment())
                }
                true
            }
        }
    }


    private fun setCurrentFragment(fragment: Fragment) {
        supportFragmentManager.beginTransaction().apply {
            replace(R.id.flFragment, fragment)
            addToBackStack(null) // Menambahkan ke back stack
            commit()
        }
    }


    fun getSharedPreferences(): SharedPreferences {
        return sharedPreferences
    }
}



