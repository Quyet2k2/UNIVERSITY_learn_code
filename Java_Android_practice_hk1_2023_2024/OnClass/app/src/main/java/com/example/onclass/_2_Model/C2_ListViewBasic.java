package com.example.onclass._2_Model;

import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;

public class C2_ListViewBasic extends AppCompatActivity {
    EditText txtInput;
    Button nut1, nut2, nut3;
    ListView listView;
    ArrayList<String> items;
    ArrayAdapter<String> adapter;

    int selectedPosition = -1; // Lưu vị trí mục đang được chọn

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_2_list_view_basic);
        AnhXa();

        items = new ArrayList<>();
        items.add("Nguyen Van A");

        adapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, items);
        listView.setAdapter(adapter);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                selectedPosition = position;
                String selectedItem = items.get(position);
                txtInput.setText(selectedItem);
            }
        });

        nut1.setOnClickListener(v -> {
            String inputText = txtInput.getText().toString();
            if (inputText.length() >= 1) {
                items.add(inputText);
                adapter.notifyDataSetChanged();
                txtInput.setText(""); // Reset EditText
            }
        });

        // Trong phương thức onCreate() của MainActivity
        nut2.setOnClickListener(v -> {
            if (selectedPosition != -1) {
                AlertDialog.Builder builder = new AlertDialog.Builder(C2_ListViewBasic.this);
                builder.setTitle("Xoá Mục")
                        .setMessage("Bạn có chắc chắn muốn xoá mục này?")
                        .setPositiveButton("Xoá", (dialog, which) -> {
                            items.remove(selectedPosition);
                            adapter.notifyDataSetChanged();
                            selectedPosition = -1; // Reset selected position
                        })
                        .setNegativeButton("Hủy", (dialog, which) -> {
                            // Đóng hộp thoại và không làm gì thêm
                            dialog.dismiss();
                        })
                        .show();
            } else {
                Toast.makeText(C2_ListViewBasic.this, "Không có mục được chọn để xoá", Toast.LENGTH_SHORT).show();
            }
        });


        nut3.setOnClickListener(v -> {
            String updatedText = txtInput.getText().toString();
            if (selectedPosition != -1) {
                AlertDialog.Builder builder = new AlertDialog.Builder(C2_ListViewBasic.this);
                builder.setTitle("Sửa Mục")
                        .setMessage("Bạn có chắc chắn muốn sửa mục này?")
                        .setPositiveButton("Sửa", (dialog, which) -> {
                            if (selectedPosition < items.size()) {
                                items.set(selectedPosition, updatedText);
                                adapter.notifyDataSetChanged();
                                selectedPosition = -1; // Reset selected position
                                txtInput.setText(""); // Clear EditText
                            }
                        })
                        .setNegativeButton("Hủy", (dialog, which) -> {
                            dialog.dismiss(); // Đóng hộp thoại khi hủy
                        })
                        .show();
            } else {
                Toast.makeText(C2_ListViewBasic.this, "Chọn mục cần sửa trước", Toast.LENGTH_SHORT).show();
            }
        });

    }

    private void AnhXa() {
        txtInput = findViewById(R.id.txtiput);
        nut1 = findViewById(R.id.nut1);
        nut3 = findViewById(R.id.nut3);
        nut2 = findViewById(R.id.nut2);
        listView = findViewById(R.id.list_view);
    }
}
