/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.services;

import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.List;
import tn.esprit.YoTalent.entities.User;
import tn.esprit.YoTalent.utils.MaConnexion;

/**
 *
 * @author USER
 */
public class ServiceUser  implements IService<User>{
    private Connection cnx;

    public ServiceUser(){
        cnx = MaConnexion.getInstance().getCnx();
    }

    @Override
    public void createOne(User user) throws SQLException {
      String req =   "INSERT INTO user (idU, nomU , email , motpass ,idRole) VALUES ('" + user.getNomU() + "''" + user.getEmail() + "')";
   
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("espacetalent ajouté !");
      
    }

    @Override
    public void updateOne(User t) throws SQLException {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public void deletOne(User t) throws SQLException {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public List<User> selectAll() throws SQLException {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }
    
}
