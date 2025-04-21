package com.example.onclass._8_DanhBa_CSDL;

import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

public class C8_DanhBa_next_CSDL extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c8_danh_ba_next_csdl);

        TextView tvName = findViewById(R.id.tvName);
        TextView tvNumber = findViewById(R.id.tvNumber);


        Intent intent = getIntent();
        C8_DanhBa c8DanhBa = intent.getParcelableExtra("person");

        tvName.setText(c8DanhBa.getName());
        tvNumber.setText(Integer.toString(c8DanhBa.getNumber()));
    }
}
