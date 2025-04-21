package com.example.onclass._4_DanhBa_ListViewCustom;

import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;

public class C4_DanhBa_ListViewCustom extends AppCompatActivity {

    int vi_tri = -1;
    private Button btnAdd, btnUpdate;
    private EditText editName, editContact;
    private ListView listContact;
    private ArrayList<C4_DanhBa> contactArrayList;
    private C4_List_DanhBa_Adapter c4ListDanhBaAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_4_danh_ba_list_view_custom);
        anhXa();
        c4ListDanhBaAdapter = new C4_List_DanhBa_Adapter(this, R.layout.activity_4_danh_ba_item, contactArrayList);
        listContact.setAdapter(c4ListDanhBaAdapter);

//        Lấy dữ liệu và thêm vào danh sách
        btnAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String name = editName.getText().toString();
                String phone = editContact.getText().toString();
                contactArrayList.add(new C4_DanhBa(name, phone, R.mipmap.ic_contact_launcher, R.drawable.ic_delete_action_name));
                c4ListDanhBaAdapter.notifyDataSetChanged();
                editName.setText("");
                editContact.setText("");
            }
        });

        listContact.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                editName.setText(contactArrayList.get(i).getTxtName());
                editContact.setText(contactArrayList.get(i).getTxtNumber());
                vi_tri = i;
            }
        });

        btnUpdate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                C4_DanhBa contact = new C4_DanhBa(editName.getText().toString(), editContact.getText().toString(), R.mipmap.ic_contact_launcher, R.drawable.ic_delete_action_name);
                contactArrayList.set(vi_tri, contact);
                c4ListDanhBaAdapter.notifyDataSetChanged();
            }
        });
    }

    private void anhXa() {
        btnAdd = findViewById(R.id.btnAdd);
        btnUpdate = findViewById(R.id.btnUpdate);
        editName = findViewById(R.id.editName);
        editContact = findViewById(R.id.editContact);
        listContact = findViewById(R.id.listContact);
        contactArrayList = new ArrayList<>();
        contactArrayList.add(new C4_DanhBa("Pham Van Quyet", "0123456789", R.mipmap.ic_contact_launcher, R.drawable.ic_delete_action_name));
    }
}
