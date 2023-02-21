/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.GUI;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.time.LocalDate;
import java.time.temporal.ChronoUnit;
import java.util.List;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
import javafx.scene.control.Label;
import javafx.scene.control.TableView;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import tn.esprit.YoTalent.entities.Evenement;
import tn.esprit.YoTalent.services.ServiceEvent;
import javafx.scene.layout.HBox;
import javafx.scene.layout.AnchorPane;
import javax.swing.JOptionPane;
import tn.esprit.YoTalent.entities.EspaceTalent;
import tn.esprit.YoTalent.services.ServiceET;
import tn.esprit.YoTalent.utils.MaConnexion;

/**
 * FXML Controller class
 *
 * @author sarra
 */
public class interfESTController implements Initializable {
    
    @FXML
    private TableView<EspaceTalent> AfficherC;
    ServiceET es=new ServiceET();
     EspaceTalent e = new EspaceTalent();
 ObservableList<EspaceTalent> espaceTalent ;
      private boolean isLightMode =true;
    @FXML
    private Button ExitCat;
    @FXML
    private TextField IdT;
    @FXML
    private TextField TitreT;
    @FXML
    private Button ModifyT;
 
    @FXML
    private TableColumn<EspaceTalent, Integer> colIdEST;
    @FXML
    private TableColumn<EspaceTalent, String> colTitre;
    @FXML
    private TableColumn<EspaceTalent, Integer> colIdU;
    @FXML
    private TableColumn<EspaceTalent, Integer> colIdVid;
    @FXML
    private TableColumn<EspaceTalent, Integer> colIdCat;
    @FXML
    private TableColumn<EspaceTalent, Integer> colIdC;
    @FXML
    private TextField DeleteT;
    @FXML
    private ImageView NextCat;
    @FXML
    private Button AddT;
    @FXML
    private ImageView PrevCat;
    @FXML
    private TextField IdVidT;
    @FXML
    private TextField IdCatT;
    @FXML
    private TextField IdCT;
    @FXML
    private TextField IdUT;
    @FXML
    private Button dd;
     private Connection cnx;
    @FXML
    private Button Planning;

    public interfESTController(){
        cnx = MaConnexion.getInstance().getCnx();
        
    }

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
       
         AfficherC.setFocusTraversable(false);
        try {
            getEvents();
        } catch (SQLException ex) {
            Logger.getLogger(interfESTController.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        
    } 
    public void getEvents() throws SQLException {
     
       
    
     
   colTitre.setCellValueFactory(new PropertyValueFactory<EspaceTalent,String>("titre"));
   colIdU.setCellValueFactory(new PropertyValueFactory<EspaceTalent,Integer>("idU"));
   colIdVid.setCellValueFactory(new PropertyValueFactory<EspaceTalent,Integer>("idVid"));
   colIdCat.setCellValueFactory(new PropertyValueFactory<EspaceTalent,Integer>("idCat"));
     colIdC.setCellValueFactory(new PropertyValueFactory<EspaceTalent,Integer>("idC"));
    
    ServiceET es=new ServiceET();
       espaceTalent= es.FetchEST();
        System.out.println(espaceTalent);
        AfficherC.setItems(espaceTalent); 
    }
    
   

    @FXML
    private void Modify_Button(ActionEvent event) {
        try{
     
       
         EspaceTalent up=new EspaceTalent(Integer.valueOf(this.IdT.getText()),this.TitreT.getText(),Integer.valueOf(this.IdUT.getText()),Integer.valueOf(this.IdVidT.getText()),Integer.valueOf(this.IdCatT.getText()),Integer.valueOf(this.IdCT.getText()));
         es.updateOne(up);
            Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("EspaceTalent update");
            alert.setContentText("EspaceTalent updated successfully!");
            alert.showAndWait();
            getEvents();
        } catch(Exception ex){
            System.out.println("fama ghalta2");
        }
         IdT.clear();
       TitreT.clear();
       IdUT.clear();
       IdVidT.clear();
        IdCatT.clear();
         IdCT.clear();;
     
        
        
        
        
    }

    @FXML
    private void ddbtn(ActionEvent event) throws SQLException {
        
      
         
         
         EspaceTalent e1 = AfficherC.getItems().get(AfficherC.getSelectionModel().getSelectedIndex());
      
        try {
            es.deletOne(e1);
        } catch (SQLException ex) {
            Logger.getLogger(interfESTController.class.getName()).log(Level.SEVERE, null, ex);
        }
         Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("EspaceTalent delete");
            alert.setContentText("EspaceTalent deleted successfully!");
            alert.showAndWait();
         getEvents();
       
        
    }
    
    
    
    
    
  
   
    
    

    @FXML
    private void AddCat_Button(ActionEvent event) throws SQLException {
        String titre;
        //BeginsAtdate.setValue(LocalDate.now());
         if ((TitreT.getText().length()==0))
                { Alert alert = new Alert(AlertType.ERROR);
                   alert.setTitle("Error ");
                    alert.setHeaderText("Error!");
                    alert.setContentText("Fields cannot be empty");
                    alert.showAndWait();}
         
         
         else{
             
           
           try{
            titre = String.valueOf(TitreT.getText());
          
        }catch(Exception exc){
            System.out.println("name exception");
            return;
        }  
            
            EspaceTalent ev=new EspaceTalent(TitreT.getText(),Integer.valueOf(this.IdUT.getText()),Integer.valueOf(this.IdVidT.getText()),Integer.valueOf(this.IdCatT.getText()),Integer.valueOf(this.IdCT.getText()));
         es.createOne(ev);
         getEvents();
          //FXMLLoader loader = new FXMLLoader(getClass().getResource("DisplayEvents.fxml"));
          Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("EspaceTalent add");
            alert.setContentText("EspaceTalent added successfully!");
            alert.showAndWait();
         }
        
    }


        
}
